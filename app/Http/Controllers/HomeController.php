<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\ProductVariants;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
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

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index(Request $request)
	{
		$HomeBanner = Cache::rememberForever('banner_all', function () {
			return HomeBanner::where('status', 'Active')->get();
		});



		$PopularProduct = Product::with(['images_data'])
			->where('status', 'Active')
			->orderBy('rating', 'desc')
			->take(8)
			->get();

		$LatestArrival = Product::with(['images_data'])
			->where('status', 'Active')
			->orderBy('created_at', 'desc')
			->take(8)
			->get();

		$featured = Product::with(['images_data'])
			->where('status', 'Active')
			->where('is_featured', '1')
			->orderBy('created_at', 'desc')
			->first();

		$categoty = Cache::rememberForever('get_home_category', function () {
			return Category::select('id', 'name', 'slug', 'image', 'banner_img')
			->where('parent_id', null)
			->where('status', 'Active')
			->orderBy('name', 'ASC')
			->limit(4)->get();
		});
		
		
		$testimonail = getTestimonail();

		return view('front.home', compact('HomeBanner', 'PopularProduct', 'LatestArrival', 'featured', 'categoty', 'testimonail'));
	}
}
