<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use response;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Orders;
use App\Models\ProductVariants;

class DashboardController extends Controller
{
	public function index()
	{
		$total_category_count = Category::whereNull('deleted_at')
			->count();

		$total_product_count = Product::where('user_id', Auth::user()->id)

			->count();

		$total_Coupon_count = Coupon::where('user_id', Auth::user()->id)
			//
			->count();

		$total_Orders_count = Orders::where('user_id', Auth::user()->id)
			//
			->count();

		//low qty products
		$low_qty_product = ProductVariants::select('product_variants.*')
			->with(['product_data'])
			->Join('products', 'products.id', '=', 'product_variants.product_id', 'right')
			->where('product_variants.user_id', Auth::user()->id)
			->where('product_variants.status', 1)
			->whereRaw('product_variants.qty <= product_variants.alert_qty')
			//->groupBy('product_id')
			->paginate(6, ['*'], 'low_qty');

		$orderLists = Orders::with(['user_data'])
			//->where('user_id', Auth::user()->id)
			->orderBy('created_at', 'desc')
			->paginate(6, ['*'], 'orders');

		return view('seller.dashboard', compact('total_category_count', 'total_product_count', 'total_Coupon_count', 'total_Orders_count', 'low_qty_product', 'orderLists'));
	}

	public function get_sales_chart_data()
	{
		$success = true;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$months = array();
		$data1 = array();
		$data2 = array();
		for ($i = 1; $i <= 7; $i++) {
			array_push($months, date("F Y", mktime(0, 0, 0, $i, 10)));
			array_push($data1, mt_rand(10000, 99999));
			array_push($data2, mt_rand(10000, 99999));
		}

		$data['labels'] = $months;
		$data['data1'] = $data1;
		$data['data2'] = $data2;

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}
}
