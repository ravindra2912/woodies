<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Models\Product;
// use Auth;
use App\Models\Variants;
use App\Models\AddToCart;
use Illuminate\Http\Request;
use App\Models\ProductVariants;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
	public function __construct()
	{
		//$this->middleware('auth');
	}
	public function cart_list(Request $request)
	{
			check_cart();

			$summary['subtotle'] = 0;
			$summary['tax'] = 0;
			$summary['igst'] = 0;
			$summary['cgst'] = 0;
			$summary['sgst'] = 0;
			$summary['discount'] = 0;
			$summary['totle'] = 0;
			$summary['cart_count'] = 0;

			$carts = AddToCart::with(['product_data', 'images_data']);
			if (Auth::check()) {
				$carts = $carts->where('user_id', Auth::user()->id);
			} else {
				$carts = $carts->where('device_id', getDeviceId());
			}
			$carts = $carts->get();

			foreach ($carts as $cdata) {

				$summary['cart_count'] += $cdata->quantity;
				$product_amount = 0;
				if ($cdata->Variants_id != '') {
					$chack_variant = ProductVariants::find($cdata->Variants_id);
					if ($chack_variant) {
						$cdata->amount =  $chack_variant->amount;
						$product_amount += $chack_variant->amount * $cdata->quantity;

						//get variant name and value
						$var = explode(',', $chack_variant->ids);
						$arr = array();
						foreach ($var as $val) {
							$variant_data = Variants::select('variant_names.name', 'variants.variant')->join('variant_names', 'variant_names.id', 'variants.variant_name_id', 'left')->find($val);
							if ($variant_data) {
								$arr[$variant_data->name] = $variant_data->variant;
							}
						}
						$cdata->v_data = $arr;
					} else {
						$cdata->amount =  $cdata->product_data->price;
						$product_amount += $cdata->product_data->price * $cdata->quantity;
					}
				} else {
					$cdata->amount =  $cdata->product_data->price;
					$product_amount += $cdata->product_data->price * $cdata->quantity;
				}

				if ($cdata->product_data->is_tax_applicable == "true") {
					$summary['igst'] += ($product_amount * $cdata->product_data->igst) / 100;
					$summary['cgst'] += ($product_amount * $cdata->product_data->cgst) / 100;
					$summary['sgst'] += ($product_amount * $cdata->product_data->sgst) / 100;
				}


				$summary['subtotle'] += $product_amount;

				$cdata->image  = getImage(isset($cdata->images_data[0]) ? $cdata->images_data[0]->image : '');
			}
			$summary['tax'] = $summary['igst'];
			$summary['totle'] = ($summary['subtotle'] - $summary['discount']) + $summary['tax'];
			//dd($carts);
			return view('front.cart.cart', compact('carts', 'summary'));
	}



	public function add_to_cart(Request $request)
	{
		$cart_count = 0;
		$auth = true;
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$rules = [
			'product_id' => 'required|exists:products,id',
			'quantity' => 'required|integer|gt:0',
		];
		$product = Product::where('id', $request->product_id)->first();
		if ($product->is_variants == 1) {
			$rules['variants'] = 'required';
		}

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		}  else {
			$request->user_id = Auth::user()->id ?? null;

			if ($product->is_variants == 1) {

				//setup product variants
				$variants = '';
				$c = 1;
				foreach ($request->variants as $val) {
					$variants .= $val;
					if (count($request->variants) != $c) {
						$variants .= ',';
					}
					$c++;
				}
				$request->variants = $variants;

				$chack_variant = ProductVariants::where('product_id', $request->product_id)
					->where('variants', $request->variants)
					->first();
				if ($chack_variant && $chack_variant->status == 1 && $chack_variant->qty >= 1) {
					if ($chack_variant->qty >= $request->quantity) {

						$check_cart = AddToCart::query();
						if (Auth::check()) {
							$check_cart = $check_cart->where('user_id', $request->user_id);
						} else {
							$check_cart = $check_cart->where('device_id', getDeviceId());
						}
						$check_cart = $check_cart->where('product_id', $request->product_id)
							->where('Variant', $request->variants)
							->first();
						if (isset($check_cart) && !empty($check_cart)) {
							$add_to_cart = $check_cart;
						} else {
							$add_to_cart = new AddToCart();
						}

						//$add_to_cart = new AddToCart();
						$add_to_cart->Variant = $request->variants;
						$add_to_cart->Variants_id = $chack_variant->id;
						$add_to_cart->product_id = $request->product_id;
						$add_to_cart->quantity = $request->quantity;
						if (Auth::check()) {
							$add_to_cart->user_id = $request->user_id;
						} else {
							$add_to_cart->device_id = getDeviceId();
						}
						$add_to_cart->save();

						$success = true;
						$message = "Product Added To Cart SuccessFully";
					} else {
						$success = false;
						$message = "Only " . $chack_variant->qty . " Available For Add To Cart";
					}
				} else {
					$success = false;
					$message = "Out Of Stock";
				}
			} else {
				$check_cart = AddToCart::query();
				if (Auth::check()) {
					$check_cart = $check_cart->where('user_id', $request->user_id);
				} else {
					$check_cart = $check_cart->where('device_id', getDeviceId());
				}
				$check_cart = $check_cart->where('product_id', $request->product_id)
					->first();
				if (isset($check_cart) && !empty($check_cart)) {
					$add_to_cart = $check_cart;
				} else {
					$add_to_cart = new AddToCart();
				}

				if ($request->quantity > $product->quantity) {
					$success = false;
					$message = "Only " . $product->quantity . " Available For Add To Cart";
				} else {
					//$add_to_cart = new AddToCart();
					// $add_to_cart->user_id = $request->user_id;
					$add_to_cart->product_id = $request->product_id;
					$add_to_cart->quantity = $request->quantity;
					if (Auth::check()) {
						$add_to_cart->user_id = $request->user_id;
					} else {
						$add_to_cart->device_id = getDeviceId();
					}
					$add_to_cart->save();

					$success = true;
					$message = 'Product Added To Cart SuccessFully';
				}
			}

			$cart_count = AddToCart::where('user_id', $request->user_id)->count();
		}
		return response()->json(["success" => $success, "auth" => $auth, "message" => $message, "data" => $data, 'cart_count' => $cart_count]);
	}

	public function check_variant(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product_id' => 'required|exists:products,id',
			'variants' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {
			$product = Product::where('id', $request->product_id)->where('status', 'Active')->first();
			$data['amount'] = 0;
			if ($product) {
				if ($product->is_variants == 1) {
					$chack_variant = ProductVariants::where('product_id', $request->product_id)
						->where('variants', $request->variants)
						->first();
					if ($chack_variant && $chack_variant->status == 1 && $chack_variant->qty >= 1) {
						$data['amount'] = $chack_variant->amount;
						$success = true;
						$message = "Data Found";
					} else {
						$data['amount'] = $chack_variant->amount;
						$success = false;
						$message = "Out Of Stock";
					}
				} else {
					$data['amount'] = $product->price;
					$success = true;
					$message = "Data Found";
				}
			} else {
				$success = false;
				$message = "Out Of Stock";
			}
		}

		return response()->json(["success" => $success, "message" => $message, "data" => $data]);
	}

	public function update_cart(Request $request)
	{
		$auth = true;
		$delete = false;
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'cart_id' => 'required|exists:add_to_carts,id',
			'quantity' => 'required|integer|gt:0',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		}  else {
			$request->user_id = Auth::user()->id ?? null;
			$check_cart = AddToCart::where('id', $request->cart_id);
			if (Auth::check()) {
				$check_cart = $check_cart->where('user_id', $request->user_id);
			} else {
				$check_cart = $check_cart->where('device_id', getDeviceId());
			}
			$check_cart = $check_cart->first();

			$product = Product::where('id', $check_cart->product_id)->where('status', 'Active')->first();

			if ($product) {
				if ($product->is_variants == 1) {
					$chack_variant = ProductVariants::where('product_id', $check_cart->product_id)
						->where('variants', $check_cart->Variant)
						->first();
					if ($chack_variant && $chack_variant->status == 1 && $chack_variant->qty >= 1) {
						if ($chack_variant->qty >= $request->quantity) {
							$check_cart->quantity = $request->quantity;
							$check_cart->save();

							$success = true;
							$message = "Cart Update SuccessFully";
						} else {
							$check_cart->quantity = $chack_variant->qty;
							$check_cart->save();
							$success = false;
							$message = "Only " . $chack_variant->qty . " Available For Add To Cart";
						}
					} else {
						$check_cart->delete();
						$success = false;
						$delete = true;
						$message = "Product Out Of Stock, And Remove From The Cart";
					}
				} else {
					if ($product->quantity >= 1) {
						if ($request->quantity > $product->quantity) {
							$check_cart->quantity = $product->quantity;
							$check_cart->save();
							$success = false;
							$message = "Only " . $product->quantity . " Available For Add To Cart";
						} else {
							$check_cart->quantity = $request->quantity;
							$check_cart->save();

							$success = true;
							$message = 'Cart Update SuccessFully';
						}
					} else {
						$check_cart->delete();
						$success = false;
						$delete = true;
						$message = "Product Out Of Stock, And Remove From The Cart";
					}
				}
			} else {
				$success = false;
				$message = "Out Of Stock";
			}
		}

		return response()->json(["auth" => $auth, "delete" => $delete, "success" => $success, "message" => $message, "data" => $data]);
	}

	public function cart_count(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {

			$cart_count = AddToCart::query();
			if (Auth::check()) {
				$cart_count = $cart_count->where('user_id', $request->user_id);
			} else {
				$cart_count = $cart_count->where('device_id', getDeviceId());
			}
			$cart_count =  $cart_count->count();
			$success = true;
			$message = "Data found";
		}

		return response()->json(["success" => $success, "message" => $message, "data" => $data, "cart_count" => $cart_count]);
	}

	public function remove_from_cart(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$rules = array();
		if (isset($request->delete_all) && $request->delete_all != 1) {
			$rules['cart_id'] = 'required|exists:add_to_carts,id';
		}
		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {
			$message = $validator->errors()->first();
		} else {

			$cart = AddToCart::where('id', $request->cart_id)->first();
			if ($request->delete_all == 1) {
				AddToCart::where('user_id', Auth::user()->id)->delete();
				$del = AddToCart::query();
				if (Auth::check()) {
					$del = $del->where('user_id', Auth::user()->id);
				} else {
					$del = $del->where('device_id', getDeviceId());
				}
				$del = $del->delete();
				$success = true;
				$message = 'Product Remove To Cart SuccessFully';
			} else if (isset($cart) && !empty($cart) && isset($cart->id)) {
				try {
					$cart->delete();

					$success = true;
					$message = 'Product Remove To Cart SuccessFully';
				} catch (\Exception $e) {
				}
			} else {
				$message = "Invalid cart data";
			}
		}

		return response()->json(["success" => $success, "message" => $message, "data" => $data]);
	}
}
