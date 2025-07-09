<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductVariants;
use App\Models\Wishlist;

class CollectionsController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function index(Request $request)
	{

		$Category = Category::where('status', 'Active')->where('level', '0')->get();
		foreach ($Category as $cat) {
			$cat->collection_data = Product::with(['images_data'])
				->whereNull('deleted_at')
				->where('status', 'Active')
				->Where('category_id', $cat->id)
				->take(4)
				->get();
			if (!empty($cat->collection_data) && count($cat->collection_data) > 0) {

				foreach ($cat->collection_data as $pdata) {

					$pdata->review_count = ProductReview::where('product_id', $pdata->id)->count();
				}
			}
		}
		return view('front.collections.collection', compact('Category'));
	}

	public function collection_details(Request $request, $slug)
	{
		$Category = Category::where('status', 'Active')->where('slug', $slug)->first();

		if ($Category) {
			$productLists = Product::with(['images_data'])
				->whereNull('deleted_at')
				->where('status', 'Active')
				->Where('category_id', $Category->id)
				->OrWhere('sub_category_id', $Category->id)
				->OrWhere('sub_category2_id', $Category->id)
				->paginate(12);


			foreach ($productLists as $pdata) {

				$pdata->review_count = ProductReview::where('product_id', $pdata->id)->count();
			}


			return view('front.collections.collection_details', compact('request', 'productLists', 'Category'));
		}
		exit('404');
	}
}
