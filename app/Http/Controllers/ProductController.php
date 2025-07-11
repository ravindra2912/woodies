<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\VariantName;
use App\Models\Variants;
use App\Models\Wishlist;
use App\Models\ProductVariants;
use App\Models\ProductReview;
use App\Models\AddToCart;
use App\Models\ProductImages;

class ProductController extends Controller
{
	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$Categoreis = Category::where('parent_id', null)->get();


		$brands = [];
		$colors = [];
		$sizes = [];
		// //brands
		// $brands = Product::whereNull('deleted_at')->where('brand','!=', null)->where('status', 'Active')->groupBy('brand')->get();

		// //colors
		// $colors = Variants::select('variants.*')
		// 			->leftJoin('variant_names as vname', 'vname.id', '=', 'variants.variant_name_id')
		// 			->where('vname.name','COLOR')
		// 			->groupBy('variant')
		// 			->get();
		// //sizes
		// $sizes = Variants::select('variants.*')
		// 			->leftJoin('variant_names as vname', 'vname.id', '=', 'variants.variant_name_id')
		// 			->where('vname.name','SIZE')
		// 			->groupBy('variant')
		// 			->get();


		return view('front.product.productlist', compact('Categoreis', 'brands', 'colors', 'sizes', 'request'));
	}

	function render_product_list(Request $request)
	{

		$limite = 12;
		//$request->size = 'S';
		//$request->color = 'GREEN';

		//$request->user_id = Auth::user()->id;

		$productLists = Product::select('products.*')->with(['images_data'])
			->whereNull('products.deleted_at')
			->where('products.status', 'Active')
			// ->groupBy('products.id')
			->distinct()
			->skip($request->page * $limite)
			->take($limite);



		//list by brand
		if ($request->brand != null) {
			$productLists = $productLists->where('products.brand', $request->brand);
		}

		//list by color
		if ($request->color != null) {
			$pvjoin = true;
			$productLists = $productLists->Join('product_variants as pvar', 'pvar.product_id', '=', 'products.id')
				->where('pvar.variants', 'LIKE', '%' . $request->color . '%');
		}

		//list by Size
		if ($request->size != null) {
			if (isset($pvjoin) && $pvjoin == true) {
				$productLists = $productLists->where('pvar.variants', 'LIKE', '%' . $request->size . '%');
			} else {
				$productLists = $productLists->Join('product_variants as pvar', 'pvar.product_id', '=', 'products.id')
					->where('pvar.variants', 'LIKE', '%' . $request->size . '%');
			}
		}

		//list by category
		if ($request->category != null) {
			$productLists = $productLists->whereHas('categories', function ($query) use ($request) {
				$query->where('slug', $request->category); // e.g., 'home-decor'
			});
		}

		//product sorting
		if ($request->sortby == 1) { //price sort asc
			$productLists = $productLists->orderBy('products.price', 'asc');
		} else if ($request->sortby == 2) { //price sort desc
			$productLists = $productLists->orderBy('products.price', 'desc');
		} else {
			$productLists = $productLists->orderBy('products.created_at', 'ASC');
		}

		$productLists = $productLists->get();


		foreach ($productLists as $pdata) {
			$pdata->review_count = ProductReview::where('product_id', $pdata->id)->count();
		}


		$html = view('front.product.RenderProductList', compact('productLists'))->render();



		return response()->json(['success' => true, 'data' => $html,]);
	}

	public function product_details(Request $request, $slug)
	{
		$product = Product::with(['categories', 'images_data'])->where('slug', $slug)->first();

		if(!$product || $product->status != 'Active'){
			return view('404');
		}

		//check stock available
		$product->stock = 0;
		if ($product->is_variants == 1) {
			$chack_variant = ProductVariants::where('product_id', $product->id)
				->where('status', 1)
				->where('qty', '>', 0)
				->first();
			if (!empty($chack_variant)) {
				$product->available_variant = explode(',', $chack_variant->variants);
				$product->stock = 1;
				$product->price = $chack_variant->amount;
			}
		} else {
			if ($product->quantity > 0) {
				$product->stock = 1;
			}
		}


		$product->is_fevourit = 0;
		if (Auth::check() && Wishlist::where('product_id', $product->id)->where('user_id', Auth::user()->id)->first()) {
			$product->is_fevourit = 1;
		}

		$product->in_cart = 0;
		if (Auth::check() && AddToCart::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first()) {
			$product->in_cart = 1;
		}

		$product->review_count = ProductReview::where('product_id', $product->id)->count();


		//get product variants
		if ($product->is_variants == 1) {
			$product->variants = VariantName::with(['variants_data'])->where('product_id', $product->id)->orderBy('id', 'asc')->get();
		}

		$related_product = Product::where('id', '!=', $product->id)->whereNull('deleted_at')->where('status', 'Active')->inRandomOrder()->limit(4)->get();
		// foreach($related_product as $rel){
		// 	$rel->review_count = ProductReview::where('product_id', $rel->id)->count();
		// }

		return view('front.product.productdetails', compact('product', 'related_product'));
	}

	public function store_review(Request $request)
	{
		$auth = true;
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product' => 'required|exists:products,id',
			'rating' => 'required|gt:0|between:1,5',
			'review_title' => 'required|max:100',
			'review' => 'required|max:256',
			'reviewer_name' => 'required|max:100',
			'email' => 'required|email|max:100',
		]);

		if ($validator->fails()) { // Validation fails
			$message = $validator->errors()->first();
		} elseif (!Auth::check()) {
			$auth = false;
		} else {
			$ProductReview = new ProductReview();
			$ProductReview->product_id = $request->product;
			$ProductReview->user_id = Auth::user()->id;
			$ProductReview->rating = trim($request->rating);
			$ProductReview->review = trim($request->review);
			$ProductReview->email = trim($request->email);
			$ProductReview->reviewer_name = trim($request->reviewer_name);
			$ProductReview->review_title = trim($request->review_title);

			try {
				$ProductReview->save();
				$this->calculet_product_review($request->product);
				$success = true;
				$message =  'Review Added Successfully';
			} catch (\Exception $e) {
				$message = $e->getMessage();
			}
		}

		return response()->json(["auth" => $auth, 'success' => $success, 'message' => $message, 'data' => $data]);
	}

	function calculet_product_review($product_id)
	{
		$Product = Product::find($product_id);
		$Product->rating = ProductReview::where('product_id', $product_id)->avg('rating');
		$Product->save();

		return true;
	}

	function get_product_review(Request $request)
	{

		$total_review = ProductReview::whereNull('deleted_at')->where('product_id', $request->id)->count();

		$ProductReview = ProductReview::with(['User_data'])
			->whereNull('deleted_at')
			//->where('status', 'Active')
			->where('product_id', $request->id)
			->orderBy('created_at', 'desc')
			->skip($request->offset)
			->take($request->limite)
			->get();

		$html = '';

		if (isset($ProductReview) && !empty($ProductReview) && count($ProductReview) > 0) {
			foreach ($ProductReview as $val) {
				$html .= '
					<div class="row rat-contin">
								<div class="col-lg-2 col-md-2 col-2 d-flex align-self-center">
									<img  src="' . getImage($val->image) . '" />
								</div>
								<div class="col-lg-10 col-md-10 col-10">
									<p class="h5 font-weight-bold">' . $val->review_title . '</p>
									<p class="mb-0">' . $val->review . '</p>
									<div>';
				for ($i = 1; $i <= 5; $i++) {
					if ($val->rating >= $i) {
						$html .= '<i class="fa-solid fa-star text-warning"></i>';
					} else {
						$html .= '<i class="fa-solid fa-star text-secondary"></i>';
					}
				}
				$html .= '			</div>
									<p><b>' . $val->reviewer_name . '</b> on ' . date_format(date_create($val->created_at), 'M d Y ') . '</p>
								</div>
							</div>
				';
			}
		}

		return response()->json(['success' => true, 'data' => $html, 'record' => $total_review]);
	}
}
