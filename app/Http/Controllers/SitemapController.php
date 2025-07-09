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

class SitemapController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
		$product = Product::whereNull('deleted_at')->where('status', 'Active')->get();
		$Category = Category::where('status', 'Active')->get();
		
		
        return Response()->view('sitemap', compact( 'product', 'Category'))->header('content-Type', 'text/xml');
    }
	
	
	
	
}
