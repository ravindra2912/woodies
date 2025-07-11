<?php

namespace app\Http\Controllers\seller;

use Str;
use Auth;

use File;
use Image;
use Redirect;

use Validator;
use App\Models\Product;
use App\Models\Category;
use App\Models\Variants;
use App\Models\VariantName;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Models\ProductReview;
use App\Exports\ProductExport;
use App\Imports\ImportProduct;
use App\Models\ProductVariants;
use Illuminate\Support\Facades\DB;
use App\Models\ProductInventoryLog;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		if ($request->ajax()) {
			$data = Product::with(['categories', 'images_data']);
			if (Auth::user()->role_id != 1) {
				$data = $data->where('user_id', Auth::user()->id);
			}

			if ($request['status'] != null) {
				$data = $data->where('status', $request['status']);
			}

			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('img', function ($row) {
					return '<img src="' . $row->image_url . '" height="100" />';
				})
				->addColumn('category', function ($row) {
					if (!empty($row->categories) && count($row->categories) > 0) {
						return $row->categories->pluck('name')->map(function ($name) {
							return ucfirst($name);
						})->implode(', ');
					}
				})

				->addColumn('action', function ($row) {
					$html = ' 	<div class="d-flex justify-content-center">
									<a href="' . route('product.edit', $row->id) . '" class="btn btn-primary tableActionBtn editBtn" title="Edit Product"><i class="right fas fa-edit"></i></a>
									<a href="' . route('product.product_review', $row->id) . '" class="btn btn-primary tableActionBtn ml-1" title="Product Reviews"><i class="right fas fa-star"></i></a>';
					if ($row->is_variants == 1) {
						$html .= '<a href="' . route('products_variants', $row->id) . '" class="btn btn-warning tableActionBtn editBtn ml-1" title="Product variants"><i class="right fas fa-sitemap"></i></a>';
					}
					$html .= '		<form action="' . route('product.destroy', $row->id) . '" id="deleteForm' . $row->id . '" method="post">
										<input type="hidden" name="_token" value="'.csrf_token().'"> 
    									<input type="hidden" name="_method" value="DELETE">
										<button type="button" class="btn btn-danger tableActionBtn deleteBtn" onclick="deleteProduct(' . $row->id . ')" title="Delete Product"><i class="right fas fa-trash"></i></button>
									</form>
								</div>';
					return $html;
				})
				->rawColumns(['action', 'img', 'category'])
				->make(true);
		}

		if (isset($request->action) && $request->action == 'export') {
			$user_id = null;
			$search = (isset($request['search']) && $request['search'] != null) ? $request['search'] : null;
			$start_date = (isset($request['start_date']) && $request['start_date'] != null) ? $request['start_date'] : null;
			$end_date = (isset($request['end_date']) && $request['end_date'] != null) ? $request['end_date'] : null;
			$status = (isset($request['status']) && $request['status'] != null) ? $request['status'] : null;


			return Excel::download(new ProductExport($user_id, $start_date, $end_date, $status,  $search), 'Products.xlsx');
		}






		return view('seller.product.index');
	}

	public function create()
	{
		$categoryData = Category::where('status', 'Active')
			->orderBy('name', 'ASC')
			->get();

		return view('seller.product.create', compact('categoryData'));
	}

	public function store(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$redirect = route('product.index');
		$data = array();

		DB::beginTransaction();
		try {

			$rules = [
				'product_name' => 'required|max:256',
				// 'brand' => 'required|max:256',
				'price' => 'required|numeric|gt:0|between:1,9999999999.99',
				'category' => 'required',
				'short_description' => 'required|max:250',
				'description' => 'required',
				'SEO_description' => 'required|max:250',
				'SEO_tags' => 'required|max:250',
			];


			if ($request->is_variants == 0) {
				$rules['quantity'] = 'required|numeric|gt:0';
			}

			// $request->is_tax_applicable = false;
			if ($request->is_tax_applicable == 'on') {
				$rules['igst'] = 'required|numeric|gt:0';
				$rules['cgst'] = 'required|numeric|gt:0';
				$rules['sgst'] = 'required|numeric|gt:0';
				// $request->is_tax_applicable = true;
			}

			// $request->is_replacement = false;
			if ($request->is_replacement == 'on') {
				$rules['replacement_days'] = 'required|numeric|gt:0';
				// $request->is_replacement = true;
			}



			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) { // Validation fails
				// $message = $validator->errors()->first();
				$message = $validator->errors();
			} else {

				$name = trim($request->product_name);
				$slug = Str::slug($name);

				$check_product_name = Product::where('user_id', Auth::user()->id)
					->where('slug', $slug)
					->count();

				if ($check_product_name == 0) { // Same name product is not exist with same category, sub category and sub category2 so insert it

					$product = new Product();
					$product->user_id = Auth::user()->id;
					// $product->category_id = $category_id;
					$product->name = $name;
					$product->is_variants = $request->is_variants;
					$product->brand = $request->brand;
					$product->short_description = $request->short_description;
					$product->slug = $slug;
					$product->price = $request->price;
					$product->description = $request->description;
					$product->SEO_description = $request->SEO_description;
					$product->SEO_tags = $request->SEO_tags;
					$product->is_tax_applicable = $request->is_tax_applicable == 'on' ? true : false;
					if ($request->is_tax_applicable == 'on') {
						$product->igst = $request->igst;
						$product->cgst = $request->cgst;
						$product->sgst = $request->sgst;
					}
					$product->is_replacement = $request->is_replacement == 'on' ? true : false;
					if ($request->is_replacement == 'on') {
						$product->replacement_days = $request->replacement_days;
					}
					if ($request->is_variants == 0) {
						$product->quantity = $request->quantity;
					}


					$product->save();
					$product->categories()->sync($request->category); // attaches category IDs

					$success = true;
					$message =  'Product has been created successfully';

					$redirect = route('product.edit', $product->id);
					DB::commit();
				} else { // Same product name is exist with same category, sub category and sub category2
					$message = 'Product already exist';
				}
			}
		} catch (\Exception $e) {
			$message = $e->getMessage();
			DB::rollback();
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$categoryData = array();

		$productData = Product::with([
			'images_data',
			'categories'
		])->where('id', $id);
		if (Auth::user()->role_id != 1) {
			$productData = $productData->where('user_id', Auth::user()->id);
		}
		$productData = $productData->first();

		if (isset($productData) && isset($productData->id)) {

			$categoryData = Category::select('id', 'name')->where('status', 'Active')
				->orderBy('name', 'ASC')
				->get();

			//$variants = ProductVariants::where('product_id', $id)->get();
		}

		return view('seller.product.edit', compact('productData', 'categoryData'));
	}

	public function upload_images(Request $request, $id)
	{
		$request->validate(
			[
				'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp',

			]
		);
		if ($request->hasfile('images')) {
			foreach ($request->file('images') as $imagefile) {
				$imgpath = fileUploadStorage($imagefile, 'product_images');

				$ProductImages = new ProductImages();
				$ProductImages->product_id = $id;
				$ProductImages->image = $imgpath;
				$ProductImages->save();
			}
		}
		return Redirect::back();
		//dd($image_name);
	}

	public function deleteimage(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make(
			$request->all(),
			[
				'id' => 'required|exists:product_images,id',
			]
		);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {

			try {
				$ProductImages = ProductImages::find($request->id);
				fileRemoveStorage($ProductImages->image);
				$ProductImages->delete();
				$success = true;
				$message =  "Image Delete SuccessFully";
			} catch (\Exception $e) {
			}
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function update(Request $request, $id)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$redirect = route('product.index');
		$data = array();

		DB::beginTransaction();

		try {

			$validate = [
				'product_name' => 'required|max:256',
				// 'brand' => 'required|max:256',
				'price' => 'required|numeric|gt:0|between:1,9999999999.99',
				'category' => 'required',
				'short_description' => 'required|max:250',
				'description' => 'required',
				'SEO_description' => 'required|max:250',
				'SEO_tags' => 'required|max:250',
				'status' => 'required|In:Active,Inactive',
			];



			if ($request->is_tax_applicable == 'on') {
				$validate['igst'] = 'required|numeric|gt:0';
				$validate['cgst'] = 'required|numeric|gt:0';
				$validate['sgst'] = 'required|numeric|gt:0';
			}

			if ($request->is_replacement == 'on') {
				$validate['replacement_days'] = 'required|numeric|gt:0';
			}

			if ($request->is_featured == 'on') {
				$validate['featured_date'] = 'required|date';
			}

			if ($request->is_variants == 0) {
				$validate['quantity'] = 'required|numeric|gt:0';
			}

			$validator = Validator::make($request->all(), $validate);

			if ($validator->fails()) { // Validation fails
				$message = $validator->errors()->first();
			} else {
				$name = trim($request->product_name);
				$slug = Str::slug($name);

				$check_product_name = Product::where('id', '!=', $id)
					->where('user_id', Auth::user()->id)
					->where('slug', $slug)
					->count();

				if ($check_product_name == 0) { // Same name product is not exist with same category, sub category and sub category2 so insert it

					$product = Product::whereNull('deleted_at')->find($id);
					// $product->category_id = $category_id;
					$product->name = $name;
					$product->slug = $slug;
					$product->brand = $request->brand;
					$product->short_description = $request->short_description;
					$product->price = trim($request->price);
					$product->is_variants = $request->is_variants;
					$product->description = $request->description;
					$product->SEO_description = $request->SEO_description;
					$product->SEO_tags = $request->SEO_tags;
					$product->is_featured = $request->is_featured == 'on' ? true : false;
					$product->status = $request->status;
					$product->is_tax_applicable = $request->is_tax_applicable == 'on' ? true : false;
					if ($request->is_tax_applicable == 'on') {
						$product->igst = $request->igst;
						$product->cgst = $request->cgst;
						$product->sgst = $request->sgst;
					}
					$product->is_replacement = $request->is_replacement == 'on' ? true : false;
					if ($request->is_replacement == 'on') {
						$product->replacement_days = $request->replacement_days;
					}
					if ($request->is_featured == 'on') {
						$product->featured_date = $request->featured_date;
					}
					if ($request->is_variants == 0) {
						$product->quantity = $request->quantity;
					}

					$product->save();

					$product->categories()->sync($request->category); // attaches category IDs

					$success = true;
					$message =  'Product has been updated successfully';
					DB::commit();
				} else { // Same product name is exist with same category, sub category and sub category2
					$message = 'Product already exist';
				}
			}
		} catch (\Exception $e) {
			$message = $e->getMessage();
			DB::rollBack();
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
	}

	public function destroy($id)
	{
		$product = Product::where('id', $id);
		if (Auth::user()->role_id != 1) {
			$product = $product->where('user_id', Auth::user()->id);
		}
		$product = $product->first();

		if (isset($product) && !empty($product) && isset($product->id)) {
			try {
				$product->delete();
				return redirect()->back()->with('success', 'Product has been deleted successfully');
			} catch (\Exception $e) {
				// dd($e->getMessage());
				return redirect()->back()->with('danger', 'Some error occurred. Please try again after sometime');
			}
		} else {
			return redirect()->back()->with('danger', 'Invalid product');
		}
	}

	public function import(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$rules = [
			'file' => 'required|mimes:xlsx',
		];

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {

			try {
				Excel::import(new ImportProduct, request()->file('file'));
				$success = true;
				$message =  'File Import SuccessFully';
			} catch (\Exception $e) {
				$message = $e->getMessage();
			}
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}


	//**************** product variant start ****************

	public function logs(Request $request, $id)
	{

		$ProductInventoryLog = ProductInventoryLog::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->where('product_id', $id);
		if (($request->product_variant_id) != null) {
			$ProductInventoryLog = $ProductInventoryLog->where('product_variant_id', $request->product_variant_id);
		}
		$ProductInventoryLog = $ProductInventoryLog->get();

		return view('seller.product.variants_log', compact('ProductInventoryLog'));
	}

	public function products_variants(Request $request, $id)
	{
		$productData = Product::where('id', $id)
			->where('user_id', Auth::user()->id)

			->first();

		$variants = ProductVariants::where('product_id', $id)->get();
		foreach ($variants as $v_data) {
			$var = explode(',', $v_data->ids);
			//dd($var);
			$arr = array();
			foreach ($var as $val) {
				$variant_data = Variants::select('variant_names.name', 'variants.variant')->join('variant_names', 'variant_names.id', 'variants.variant_name_id', 'left')->find($val);
				if ($variant_data) {
					$arr[$variant_data->name] = $variant_data->variant;
				}
			}
			$v_data->v_data = $arr;
		}

		return view('seller.product.variants', compact('productData', 'variants'));
	}

	public function insert_product_variant(Request $request, $pid)
	{

		//dd('a');

		$c = 0;
		$array = array();
		if ($request->variant_name != null && $request->variants != null) {
			foreach ($request->variant_name as $vname) {
				if ($vname != null) {
					//insert variant name
					$v_name = new VariantName();
					$v_name->name = strtoupper(str_replace(' ', '', $vname));
					$v_name->product_id = $pid;
					$v_name->save();
					$v_name_id = $v_name->id;

					//insert variants
					$variants = explode(',', $request->variants[$c]);
					$varaay = [];
					foreach ($variants as $vr) {
						if ($vr != null) {

							$v = new Variants();
							$v->variant = strtoupper(str_replace(' ', '', $vr));
							$v->product_id = $pid;
							$v->variant_name_id = $v_name_id;
							$v->save();
							$v_id = $v->id;

							$varaay[] = $v_id;
						}
					}
					$c++;
					$array[] = $varaay;
				}
			}
			if ($array != null) {
				$res = $this->combinations($array);
				$Product_details = Product::find($pid);
				foreach ($res as $val) {
					if ($c == 1) {
						$var_name = '';
						$var_ids = $val;
						//get variant name
						$vname = Variants::where('id', $val)->first();
						$vname = $vname->variant;

						if ($var_name != null) {
							$var_name .= ',' . $vname;
						} else {
							$var_name .= $vname;
						}
					} else {
						$var_name = '';
						$var_ids = implode(',', $val);
						foreach ($val as $v) {
							//get variant name
							$vname = Variants::where('id', $v)->first();
							$vname = $vname->variant;

							if ($var_name != null) {
								$var_name .= ',' . $vname;
							} else {
								$var_name .= $vname;
							}
						}
					}

					$pv = new ProductVariants();
					$pv->product_id = $pid;
					$pv->user_id = Auth::user()->id;
					$pv->variants = $var_name;
					$pv->ids = $var_ids;
					$pv->qty = 1;
					$pv->amount = $Product_details->price;
					$pv->save();
				}
			}
		}
		return Redirect::back();
	}

	public function combinations($arrays, $i = 0)
	{
		if (!isset($arrays[$i])) {
			return array();
		}
		if ($i == count($arrays) - 1) {
			return $arrays[$i];
		}

		// get combinations from subsequent arrays
		$tmp = $this->combinations($arrays, $i + 1);

		$result = array();
		// concat each array from tmp with each element from $arrays[$i]
		foreach ($arrays[$i] as $v) {
			foreach ($tmp as $t) {
				$result[] = is_array($t) ? array_merge(array($v), $t) : array($v, $t);
			}
		}
		return $result;
	}

	public function change_variant_amount(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product_variant_id' => 'required|exists:product_variants,id',
			'amount' => 'required|numeric',
		]);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {
			$ProductVariants = ProductVariants::find($request->product_variant_id);
			$ProductVariants->amount = $request->amount;

			try {
				$ProductVariants->save();
				$success = true;
				$message =  "Price Changed Successfully";
			} catch (\Exception $e) {
			}
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function change_variant_status(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product_variant_id' => 'required|exists:product_variants,id',
			'status' => 'required|numeric',
		]);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {
			$ProductVariants = ProductVariants::find($request->product_variant_id);
			$ProductVariants->status = $request->status;

			try {
				$ProductVariants->save();
				$success = true;
				$message =  "Status Changed Successfully";
			} catch (\Exception $e) {
			}
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function change_alert_qty(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product_variant_id' => 'required|exists:product_variants,id',
			'alert_qty' => 'required|numeric|gt:0',
		]);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {
			$ProductVariants = ProductVariants::find($request->product_variant_id);
			$ProductVariants->alert_qty = $request->alert_qty;

			try {
				$ProductVariants->save();
				$success = true;
				$message =  "Price Changed Successfully";
			} catch (\Exception $e) {
			}
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function change_variant_qty(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product_variant_id' => 'required|exists:product_variants,id',
			'type' => 'required|numeric',
			'value' => 'required|numeric|gt:0',
		]);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {
			$ProductVariants = ProductVariants::find($request->product_variant_id);
			$old_qty = $ProductVariants->qty;
			if ($request['type'] == 0) {
				$vv = $ProductVariants->qty - $request->value;
				if ($vv <= 0) {
					$vv = 0;
				}
			} else {
				$vv = $ProductVariants->qty + $request->value;
			}
			$ProductVariants->qty = $vv;

			$ProductInventoryLog = new ProductInventoryLog();
			$ProductInventoryLog->log = 'Update QTY ' . $old_qty . ' to ' . $vv;
			$ProductInventoryLog->variant = $ProductVariants->variants;
			$ProductInventoryLog->product_id = $ProductVariants->product_id;
			$ProductInventoryLog->user_id = Auth::user()->id;
			$ProductInventoryLog->product_variant_id = $ProductVariants->id;

			try {
				$ProductVariants->save();
				$ProductInventoryLog->save();
				$success = true;
				$message = "QTY Changed Successfully";
			} catch (\Exception $e) {
			}
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function delete_product_variant(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product_variant_id' => 'required|exists:product_variants,id',
		]);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {
			$ProductVariants = ProductVariants::find($request->product_variant_id);

			try {
				$ProductVariants->delete();
				$success = true;
				$message =  "Variant Deleted Successfully";
			} catch (\Exception $e) {
			}
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function delete_all_product_variant(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product_id' => 'required',
		]);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {


			try {
				$Variants = Variants::where('product_id', $request->product_id)->delete();
				$VariantName = VariantName::where('product_id', $request->product_id)->delete();
				$ProductVariants = ProductVariants::where('product_id', $request->product_id)->delete();
				$success = true;
				$message =  "All Variant Deleted Successfully";
			} catch (\Exception $e) {
			}
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	//***************** product variant end *****************



	public function get_product_by_category(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'category' => 'required|exists:categories,id',
		]);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} else {
			$Product_data = Product::select('id', 'name')
				->whereHas('categories', function ($q) use ($request) {
					$q->where('category_id', $request->category); // Match category ID
				})
				->where('user_id', Auth::user()->id)
				->where('status', 'Active')
				->whereNull('deleted_at')
				->orderBy('name', 'ASC')
				->get();
		}



		if (isset($Product_data) && !empty($Product_data) && $Product_data->isNotEmpty()) {
			$success = true;
			$message = "Data found";
			$data = $Product_data;
		} else {
			$message = "Data not found";
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function product_review(Request $request, $id)
	{

		$ProductReview = ProductReview::with(['User_data'])
			->where('product_id', $id)
			->orderBy('created_at', 'desc');


		//filters 
		if ($request['search'] != null) {
			$ProductReview = $ProductReview->where('id', 'LIKE', '%' . $request['search'] . '%')
				->orwhere('email', 'LIKE', '%' . $request['search'] . '%')
				->orwhere('reviewer_name', 'LIKE', '%' . $request['search'] . '%');
		}
		if ($request['start_date'] != null) {
			$ProductReview = $ProductReview->where('created_at', '>=', $request['start_date']);
		}
		if ($request['end_date'] != null) {
			$ProductReview = $ProductReview->where('created_at', '<=', date('Y-m-d', strtotime('+1 day', strtotime($request['end_date']))));
		}
		//if($request['status'] != null){ $ProductReview = $ProductReview->where('status',$request['status']); }

		$ProductReview = $ProductReview->paginate(10);

		return view('seller.product.reviewslist', compact('ProductReview', 'request', 'id'));
	}
}
