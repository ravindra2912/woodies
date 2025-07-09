<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\ProductVariants;
use App\Models\AddToCart;

class WishlistController extends Controller
{
	public function wishlist_list(Request $request)
	{

		if (Auth::check()) {
			$Wishlist_data = Product::select('products.*')
				->join('wishlists', 'products.id', '=', 'wishlists.product_id')
				->where('wishlists.user_id', Auth::user()->id)
				->whereNull('deleted_at')
				->where('status', 'Active')
				->paginate(10);

			foreach ($Wishlist_data as $pdata) {

				//check stock available
				$pdata->stock = 'Out Of Stock';
				if ($pdata->is_variants == 1) {
					$chack_variant = ProductVariants::where('product_id', $pdata->id)
						->where('status', 1)
						->where('qty', '>', 0)
						->first();
					if (!empty($chack_variant)) {
						$pdata->stock = 'In Stock';
					}
				} else {
					if ($pdata->quantity > 0) {
						$pdata->stock = 'In Stock';
					}
				}

				$pdata->in_cart = 0;
				if (Auth::check() && AddToCart::where('user_id', Auth::user()->id)->where('product_id', $pdata->id)->first()) {
					$pdata->in_cart = 1;
				}

				$pdata->image  = getImage(isset($pdata->images_data[0]->image) ? $pdata->images_data[0]->image : '');
			}
			return view('front.account.wishlist.index', compact('Wishlist_data'));
		} else {
			return redirect('/');
		}
	}

	public function add_to_wishlist(Request $request)
	{
		$auth = true;
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();
		$is_fevourit = 0;
		$wishlist_count = 0;

		$validator = Validator::make($request->all(), [
			'product_id' => 'required|exists:products,id',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} elseif (!Auth::check()) {
			$auth = false;
		} else {
			$request->user_id =	Auth::user()->id;
			$check = Wishlist::where('user_id', $request->user_id)
				->where('product_id', $request->product_id)
				->first();
			if (!$check) {
				$Wishlist = new Wishlist();
				$Wishlist->user_id = $request->user_id;
				$Wishlist->product_id = $request->product_id;
				$Wishlist->save();

				$is_fevourit = 1;
				$success = true;
				$message = "SuccessFully Added In To Wishlist";
			} else {
				$check->delete();
				$success = true;
				$message = "SuccessFully Remove In To Wishlist";
			}
			$wishlist_count = Wishlist::where('user_id', Auth::user()->id)->count();
		}

		return response()->json(["auth" => $auth, "success" => $success, "message" => $message, "wishlist_count" => $wishlist_count, "is_fevourit" => $is_fevourit, "data" => $data]);
	}
}
