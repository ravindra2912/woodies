<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\AddToCart;
use App\Models\ProductVariants;
use App\Models\Product;

class AddToCartController extends Controller
{
	public function cart_list(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();
		try {
			$summary['subtotle'] = 0;
			$summary['tax'] = 0;
			$summary['igst'] = 0;
			$summary['cgst'] = 0;
			$summary['sgst'] = 0;
			$summary['discount'] = 0;
			$summary['totle'] = 0;
			$summary['cart_count'] = 0;

			$add_to_cart = AddToCart::where('user_id', getUserId())
				->with(['product_data'])
				->get();

			foreach ($add_to_cart as $cdata) {

				$summary['cart_count'] += $cdata->quantity;
				$product_amount = 0;
				if ($cdata->Variants_id != '') {
					$chack_variant = ProductVariants::find($cdata->Variants_id);
					if ($chack_variant) {
						$cdata->amount =  $chack_variant->amount;
						$product_amount += $chack_variant->amount * $cdata->quantity;
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
			}
			$summary['tax'] = $summary['igst'];
			$summary['totle'] = ($summary['subtotle'] - $summary['discount']) + $summary['tax'];
			if (isset($add_to_cart) && $add_to_cart->isNotEmpty()) {
				$success = true;
				$message = "Data found";
				$data['cart'] = $add_to_cart;
				$data['summary'] = $summary;
			} else {
				$message = "No data found";
			}
		} catch (\Exception $e) {
			$message = $e->getMessage();
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function add_to_cart(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'product_id' => 'required|exists:products,id',
			'quantity' => 'required|integer|gt:0',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {
			$product = Product::where('id', $request->product_id)->first();

			if ($product->is_variants == 1) {
				$chack_variant = ProductVariants::where('product_id', $request->product_id)
					->where('variants', $request->variants)
					->first();
				if ($chack_variant && $chack_variant->status == 1 && $chack_variant->qty >= 1) {
					if ($chack_variant->qty >= $request->quantity) {

						$check_cart = AddToCart::where('user_id', getUserId())
							->where('product_id', $request->product_id)
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
						$add_to_cart->user_id = getUserId();
						$add_to_cart->product_id = $request->product_id;
						$add_to_cart->quantity = $request->quantity;
						$add_to_cart->save();

						$success = true;
						$message ="Product has been added to cart successfully";
					} else {
						$success = false;
						$message = "Only " . $chack_variant->qty . " Available For Add To Cart";
					}
					return response()->json(["success" => $success, "message" => $message, "data" => $data]);
				} else {
					$success = false;
					$message = "Out Of Stock";
				}
			} else {

				$check_cart = AddToCart::where('user_id', getUserId())
					->where('product_id', $request->product_id)
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
					$add_to_cart->user_id = getUserId();
					$add_to_cart->product_id = $request->product_id;
					$add_to_cart->quantity = $request->quantity;
					$add_to_cart->save();

					$success = true;
					$message = "Product has been added to cart successfully";
				}
			}

			$data['cartData'] = AddToCart::select('id', 'user_id', 'product_id', 'quantity', 'Variants_id', 'Variant')->where('user_id', getUserId())
				->get();
		}

		return response()->json(["success" => $success, "message" => $message, "data" => $data]);
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
					if ($chack_variant && $chack_variant->status == 1) {
						$data['amount'] = $chack_variant->amount;
						$success = true;
						$message = "Data Found";
					} else {
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

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
			'cart_id' => 'required|exists:add_to_carts,id',
			'quantity' => 'required|integer|gt:0',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {

			$check_cart = AddToCart::where('id', $request->cart_id)
				->where('user_id', $request->user_id)
				->first();

			if (isset($check_cart) && isset($check_cart->id)) {
				$check_cart->quantity = $request->quantity;
				$check_cart->save();

				$success = true;
				$message = "Cart has been updated successfully";
			} else {
				$message = "Product not exist in cart so please add it first in the cart";
			}
		}

		return response()->json(["success" => $success, "message" => $message, "data" => $data]);
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

			$cart_count = AddToCart::where('user_id', $request->user_id)->count();
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

		$validator = Validator::make($request->all(), [
			'cart_id' => 'required|exists:add_to_carts,id',
		]);

		if ($validator->fails()) {
			$message = $validator->errors()->first();
		} else {

			$cart = AddToCart::where('id', $request->cart_id)
				->where('user_id', getUserId())
				->first();

			if (isset($cart) && !empty($cart) && isset($cart->id)) {
				try {
					$cart->delete();

					$success = true;
					$message = "Product has been removed from cart successfully";
				} catch (\Exception $e) {
				}
			} else {
				$message = "Invalid cart data";
			}
		}

		return response()->json(["success" => $success, "message" => $message, "data" => $data]);
	}
}
