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
		$user = Auth::user();
		$isAdmin = $user->role_id == 1;

		// Total categories (soft delete check)
		$total_category_count = Category::count();

		// Total products
		$total_product_count = Product::when(!$isAdmin, function ($query) use ($user) {
			$query->where('user_id', $user->id);
		})->count();

		// Total coupons
		$total_Coupon_count = Coupon::when(!$isAdmin, function ($query) use ($user) {
			$query->where('user_id', $user->id);
		})->count();

		// Total orders
		$total_Orders_count = Orders::when(!$isAdmin, function ($query) use ($user) {
			$query->where('user_id', $user->id);
		})->count();

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
			->Join('products', 'products.id', '=', 'product_variants.product_id', 'right')
			->when(!$isAdmin, function ($query) use ($user) {
				$query->where('product_variants.user_id', $user->id);
			})
			->where('product_variants.status', 1)
			->whereRaw('product_variants.qty <= product_variants.alert_qty');

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
			->where('products.quantity', '<', 5)
			->when(!$isAdmin, function ($query) use ($user) {
				$query->where('user_id', $user->id);
			});

		// Combine both using union
		$low_qty_product = $lowVariantsQuery
			->union($lowProductsQuery)
			->orderBy('qty', 'asc')
			->paginate(6, ['*'], 'low_qty');

		$orderLists = Orders::with('user_data')
			->when(!$isAdmin, function ($query) use ($user) {
				$query->where('user_id', $user->id);
			})
			->orderByDesc('created_at')
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
