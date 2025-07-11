<?php

namespace App\Http\Controllers\Seller;

use Auth;
use response;
use App\Models\Coupon;
use App\Models\Orders;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\ProductVariants;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function index()
	{
		$total_category_count = Category::whereNull('deleted_at')
			->count();

		$total_product_count = Product::query();
		if (Auth::user()->role_id != 1) {
			$total_product_count = $total_product_count->where('user_id', Auth::user()->id);
		}
		$total_product_count = $total_product_count->count();

		$total_Coupon_count = Coupon::query();
		if (Auth::user()->role_id != 1) {
			$total_Coupon_count = $total_Coupon_count->where('user_id', Auth::user()->id);
		}
		$total_Coupon_count = $total_Coupon_count->count();

		$total_Orders_count = Orders::query();
		if (Auth::user()->role_id != 1) {
			$total_Orders_count = $total_Orders_count->where('user_id', Auth::user()->id);
		}
		$total_Orders_count = $total_Orders_count->count();

		//low qty products
		$lowVariantsQuery = ProductVariants::select(
			'product_variants.product_id',
			'products.name',
			'product_variants.variants',
			'product_variants.alert_qty',
			'product_variants.qty',
			'product_variants.amount',
			DB::raw("'variants' as type")
		)
			->Join('products', 'products.id', '=', 'product_variants.product_id', 'right');
		if (Auth::user()->role_id != 1) {
			$lowVariantsQuery = $lowVariantsQuery->where('product_variants.user_id', Auth::user()->id);
		}
		$lowVariantsQuery = $lowVariantsQuery->where('product_variants.status', 1)
			->whereRaw('product_variants.qty <= product_variants.alert_qty');
		//->groupBy('product_id')
		// ->paginate(6, ['*'], 'low_qty');

		// Second query: products with qty < 5
		$lowProductsQuery = Product::selectRaw('
				products.id AS product_id,
				products.name AS name,
				NULL AS variants,
				NULL AS alert_qty, 
				products.quantity AS qty,
				products.price AS amount,
				"product" as type
			')
			->where('products.quantity', '<', 5);

		if (Auth::user()->role_id != 1) {
			$lowProductsQuery->where('user_id', Auth::id());
		}

		// Combine both using union
		$low_qty_product = $lowVariantsQuery
			->union($lowProductsQuery)
			->orderBy('qty', 'asc')
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
