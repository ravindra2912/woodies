<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\VariantName;
use App\Models\Wishlist;
use App\Models\ProductVariants;
use Illuminate\Support\Facades\Auth;

class ProducsController extends Controller
{
	public function producs(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'offset' => 'required|numeric',
			'limite' => 'required|numeric|gt:0',
		]);

		if ($validator->fails()) {
			$message = $validator->errors()->first();
		} else {
			$productLists = Product::select('id', 'name', 'slug', 'price', 'brand', 'status', 'is_variants')
				->with(['getFavourite:id,product_id,user_id'])
				->whereNull('deleted_at')
				->where('status', 'Active')
				->skip($request->offset)
				->take($request->limite);
			if ($request->search != null) {
				$productLists = $productLists->where('name', 'like', '%' . $request->search . '%');
			}

			//list by category
			if ($request->category != null) {
				$getCatData = Category::select('id')
					->where('slug', $request->category)
					->where('parent_id', null)
					->where('level', 0)
					->where('status', 'Active')
					->first();
				if ($getCatData) {
					$productLists = $productLists->where('category_id', $getCatData->id)
						->orWhere('sub_category_id', $getCatData->id)
						->orWhere('sub_category2_id', $getCatData->id);
				}
			}

			//product sorting
			if ($request->sortby == 1) { //price sort asc
				$productLists = $productLists->orderBy('price', 'asc');
			} else if ($request->sortby == 2) { //price sort desc
				$productLists = $productLists->orderBy('price', 'desc');
			} else {
				$productLists = $productLists->orderBy('created_at', 'ASC');
			}

			$productLists = $productLists->get();

			foreach ($productLists as $pdata) {
				$pdata->stock = 0;
				if ($pdata->is_variants == 1) {
					$chack_variant = ProductVariants::where('product_id', $request->product_id)
						->where('status', 1)
						->where('qty', '>', 0)
						->exists();
					if ($chack_variant) {
						$pdata->stock = 1;
					}
				} else {
					if ($pdata->quantity > 0) {
						$pdata->stock = 1;
					}
				}
				$pdata->is_fevourit = $pdata->getFavourite ? true : false;
			}

			if (isset($productLists) && $productLists->isNotEmpty()) {
				$success = true;
				$message = "Data found";
				$data = $productLists;
			} else {
				$message = "No data found";
			}
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'Currency' => (new CurrencyController)->get_Currency()]);
	}

	public function product_details(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'slug' => 'required|exists:products,slug',
		]);

		if ($validator->fails()) {
			$message = $validator->errors()->first();
		} else {
			$product = Product::select('*')
				->with(['images_data:id,image,product_id', 'getFavourite:id,product_id,user_id'])
				->where('slug', $request->slug)
				->first();
			if ($product) {
				//check stock available
				$product->stock = 0;
				if ($product->is_variants == 1) {
					$chack_variant = ProductVariants::where('product_id', $request->product_id)
						->where('status', 1)
						->where('qty', '>', 0)
						->first();
					if ($chack_variant) {
						$product->stock = 1;
					}
				} else {
					if ($product->quantity > 0) {
						$product->stock = 1;
					}
				}

				$product->is_fevourit = $product->getFavourite ? true : false;

				// $data = Wishlist::where('product_id', $product->id)->where('user_id', getUserId())->exists();


				//get product variants
				$product->variants = array();
				if ($product->is_variants == 1) {
					$product->variants = VariantName::with(['variants_data'])->where('product_id', $request->product_id)->orderBy('id', 'asc')->get();
				}


				//get related products
				$product->related_products = Product::select('id', 'name', 'slug', 'price', 'brand', 'status', 'is_variants')
					->with(['getFavourite:id,product_id,user_id'])
					->where('id', '!=', $product->id)
					->where('status', 'Active')
					->limit(4)
					// ->inRandomOrder()
					->get();
				foreach ($product->related_products as $rproduct) {
					$rproduct->is_fevourit = $rproduct->getFavourite ? true : false;
				}



				$success = true;
				$message = "Data found";
				$data = $product;
			} else {
				$message = "No data found";
			}
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'Currency' => (new CurrencyController)->get_Currency()]);
	}
}
