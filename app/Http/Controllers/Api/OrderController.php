<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Orders;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderLog;
use App\Models\AddToCart;
use App\Models\OrdersItems;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Models\ProductVariants;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

	public function apply_coupon(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'coupon_code' => 'required|exists:coupons,coupon_code',
			'total' => 'required|gt:0',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {

			$check = $this->check_coupon($request->coupon_code, Auth::user()->id);
			if ($check && $check['status'] == true) {
				$data['discount'] = $check['discount'];
				$data['total'] = $request->total - $check['discount'];
				$data['free_delivery'] = $check['free_delivery'];

				$success = true;
			}
			$message = $check['msg'];
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	function check_coupon($coupon_code, $user_id)
	{
		$data['status'] = false;
		$data['msg'] = 'coupon_not_exist';
		$data['discount'] = 0;
		$data['free_delivery'] = false;
		$amount = 0;
		$date = date('Y-m-d');
		$coupon = Coupon::where('coupon_code', $coupon_code)
			->whereDate('active_date', '<=', $date)
			->whereDate('end_date', '>=', $date)
			->where('status', 'Active')
			->first();

		//die;
		if ($coupon) {
			$data['coupon_id'] = $coupon->id;
			$add_to_cart = AddToCart::where('user_id', $user_id)
				->with(['product_data'])
				->get();

			foreach ($add_to_cart as $cart) {
				if (isset($cart->product_data) && $cart->product_data->coupon_id == $coupon->id) {
					if ($cart->Variants_id != null) {
						$ProductVariants = ProductVariants::find($cart->Variants_id);
						if ($ProductVariants) {
							$amount += $ProductVariants->amount * $cart->quantity;
						} else {
							$amount += $cart->product_data->price * $cart->quantity;
						}
					} else {
						$amount += $cart->product_data->price * $cart->quantity;
					}
				}
			}

			if ($amount > 0) {
				if ($coupon->coupon_type == 1) { // percentage
					$data['discount'] = ($amount * $coupon->coupon_percent) / 100;
				} else if ($coupon->coupon_type == 2) { // amount
					if ($amount >=  $coupon->coupon_amount) {
						$data['discount'] = $coupon->coupon_amount;
					} else {
						$data['discount'] = $amount;
					}
				} else  if ($coupon->coupon_type == 3) { // free shiping
					$data['free_delivery'] = true;
				}
				$data['status'] = true;
				$msg = 'Coupon Apply successFully';
				$data['msg'] = $msg;
			}



			/* $coupons_count = Orders::where('coupon_id',$coupon->id)->count();
				$coupons_count_per_user = Orders::where('coupon_id',$coupon->id)->where('user_id',$user_id)->first();
				
				if($coupon->minimum_requrment_type == 1 && $coupon->minimum_requrment >= $amount){ //check amount
					$msg = 'Order Amount Must be Greater Than '.$coupon->minimum_requrment;
				}else if($coupon->minimum_requrment_type == 2 && $coupon->minimum_requrment >= $quantity){ //check items
					$msg = 'Order Item Must be Greater Than '.$coupon->minimum_requrment; 
				}else if($coupon->is_coupon_limit == 1 && $coupon->coupon_limit <= $coupons_count){ //check coupone total limit
					$msg = 'Coupon Lime Is Over'; 
				}else if($coupon->once_per_user == 1 && $coupons_count_per_user){ //check coupone use once per user
					$msg = 'Coupon Use Once Per User'; 
				}else{
					
					if($coupon->coupon_type == 1){ // percentage
						$data['discount'] = ($amount * $coupon->coupon_percent)/100;
					}else if($coupon->coupon_type == 2){ // amount
						if($amount >=  $coupon->coupon_amount){
							$data['discount'] = $coupon->coupon_amount;
						}else{
							$data['discount'] = $amount;
						}
					}else  if($coupon->coupon_type == 3){ // free shiping
						$data['free_delivery'] = true;
					}
					$data['status'] = true;
					$msg = 'Coupon Apply successFully';
				} */
		}
		return $data;
	}

	public function place_order(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'contact' => 'required|numeric|digits:10',
			'address' => 'required|string|max:250',
			'address2' => 'nullable|string|max:250',
			'address_id' => 'nullable|exists:addresses,id',
			'state' => 'required|string|max:100',
			'city' => 'required|string|max:100',
			'zipcode' => 'required|numeric|digits:6',
			'payment_type' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {
			$cart_list = AddToCart::where('user_id', Auth::user()->id)->with(['product_data'])->get();
			//$data = $cart_list;

			if (isset($cart_list) && $cart_list->isNotEmpty()) {

				// $address = Address::find($request->address_id);

				$Orders = new Orders();
				$Orders->user_id = Auth::user()->id;
				$Orders->address_id = $request->address_id;
				$Orders->name = $request->name;
				$Orders->contact = $request->contact;
				$Orders->address = $request->address;
				$Orders->address2 = $request->address2;
				$Orders->country = 'india';
				$Orders->state = $request->state;
				$Orders->city = $request->city;
				$Orders->zipcode = $request->zipcode;
				$Orders->payment_type = $request->payment_type;

				try {
					$Orders->save();

					$subtotal = 0;
					$qty = 0;
					$tax = 0;
					$discount = 0;
					$total = 0;
					foreach ($cart_list as $cl) {
						$product_amount = 0;
						$OrdersItems = new OrdersItems();
						if ($cl->Variants_id != null) {


							$ProductVariants = ProductVariants::find($cl->Variants_id);
							$ProductVariants->qty = $ProductVariants->qty - $cl->quantity;
							$ProductVariants->save();


							$OrdersItems->Variants_id = $ProductVariants->id;
							$OrdersItems->Variant = $ProductVariants->variants;

							$product_amount += $ProductVariants->amount * $cl->quantity;
							$OrdersItems->product_price = $ProductVariants->amount;
						} else {
							$product_amount += $cl->product_data->price * $cl->quantity;
							$OrdersItems->product_price = $cl->product_data->price;
						}
						$subtotal += $product_amount;
						$qty += $cl->quantity;

						if ($cl->product_data->is_tax_applicable == "true") {

							$OrdersItems->igst = ($product_amount * $cl->product_data->igst) / 100;
							$OrdersItems->cgst = ($product_amount * $cl->product_data->cgst) / 100;
							$OrdersItems->sgst = ($product_amount * $cl->product_data->sgst) / 100;

							$tax += $OrdersItems->igst;
						}

						$OrdersItems->order_id = $Orders->id;
						$OrdersItems->product_id = $cl->product_id;
						$OrdersItems->product_name = $cl->product_data->name;
						$OrdersItems->quantity = $cl->quantity;
						$OrdersItems->save();
					}


					//check coupons
					if (isset($request->coupon_code) && $request->coupon_code != '') {
						$check = $this->check_coupon($request->coupon_code, Auth::user()->id);
						if ($check && $check['status'] == true) {
							$discount = $check['discount'];
							//$data['free_delivery'] = $check['free_delivery'];
							$Orders->coupon_id = $check['coupon_id'];
							$Orders->coupon_code = $request->coupon_code;
						}
					}


					$Orders->subtotal = $subtotal;
					$Orders->discount = $discount;
					$Orders->tax = $tax;
					$Orders->total = ($subtotal - $discount) + $tax;
					$Orders->save();

					//create log
					$OrderLog = new OrderLog();
					$OrderLog->order_id = $Orders->id;
					$OrderLog->order_status = 1;
					$OrderLog->save();

					//empty card
					AddToCart::where('user_id', Auth::user()->id)->delete();


					//order data
					$order_data = Orders::where('user_id', Auth::user()->id)
						->where('id', $Orders->id)
						->with(['order_items_data'])
						->first();

					if (isset($order_data) && !empty($order_data)) {
						$data = $order_data;
					}

					$success = true;
					$message = "Order Placed Successfully";
				} catch (\Exception $e) {
					$message = $e->getMessage();
				}
			} else {
				$message = "Your Cart is Empty";
			}
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function coupon_list(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$coupon_data = Coupon::where('status', 'Active')->get();
		if (isset($coupon_data) && !empty($coupon_data)) {
			foreach ($coupon_data as $cdata) {
				$cdata->created_date = date_format(date_create($cdata->created_at), 'Y-m-d H:i:s');
				$cdata->active_date = date_format(date_create($cdata->active_date), 'Y-m-d');
				$cdata->active_time = date_format(date_create($cdata->active_time), 'Y-m-d');
			}
			$success = true;
			$message = "Data found";
			$data = $coupon_data;
		} else {
			$message = "No data found";
		}


		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function order_list(Request $request)
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
			$order_data = Orders::select('id', 'total', 'payment_status', 'status', 'created_at')
				->where('user_id', Auth::user()->id)
				->OrderBy('created_at', 'desc')
				->skip($request->offset)
				->take($request->limite)
				->get();

			if (isset($order_data) && $order_data->isNotEmpty()) {
				$success = true;
				$message = "Data found";
				$data = $order_data;
			} else {
				$message = "No data found";
			}
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function order_details(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'order_id' => 'required|exists:orders,id',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {
			$order_data = Orders::query()
			->select(
				'id',
				'name',
				'contact',
				'address',
				'address2',
				'country',
				'state',
				'city',
				'zipcode',
				'discount',
				'subtotal',
				'tax',
				'shipping',
				'total',
				'payment_status',
				'status',
				'created_at'
			)
				->where('user_id', Auth::user()->id)
				->where('id', $request->order_id)
				->with(['order_items_data:id,order_id,product_id,product_name,product_price,quantity', 'order_logs_status'])
				->first();


			if (isset($order_data) && !empty($order_data)) {

				$success = true;
				$message = "Data found";
				$data = $order_data;
			} else {
				$message = "No data found";
			}
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function order_payment(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
			'order_id' => 'required|exists:orders,id',
			'payment_transaction_id' => 'required',
			'status' => 'required',
			'payment_by' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {
			$order_data = Orders::where('user_id', Auth::user()->id)
				->where('id', $request->order_id)
				->first();
			if (isset($order_data) && !empty($order_data)) {
				$order_data->payment_transaction_id = $request->payment_transaction_id;
				$order_data->payment_status = $request->status;
				$order_data->payment_by = $request->payment_by;
				$order_data->save();

				if ($request->status == 'Succeeded') { //success 
					//mail

					$order_data->status = "new";
					$order_data->save();

					$success = true;
					$message = "Payment Success";
				} else if ($request->status == 'Fail') { //  Failed
					$message = "Payment Failed";
				}
			} else {
				$message = "No data found";
			}
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}

	public function replace_product(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
			'order_item_id' => 'required|exists:orders_items,id',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {
			$OrdersItems = OrdersItems::where('id', $request->order_item_id)->first();
			if (isset($OrdersItems) && !empty($OrdersItems)) {
				$product = Product::where('id', $OrdersItems->product_id)->first();
				if (isset($product) && !empty($product)) {
					$date1 = date_format(date_create($OrdersItems->created_at), 'Y-m-d H:i:s');
					$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($date1);
					$diff = abs(round($diff / 86400));

					if ($product->is_replacement == 'true' && $diff >= 0 && $diff <= $product->replacement_days) {
						$success = true;
						$message = "SuccessFully Add Product To Replacement";
					} else {
						$success = false;
						$message = "Product not Applicable to Replace";
					}
				}
			}
		}
		return response()->json(["success" => $success, "message" => $message, "data" => $data]);
	}

	public function order_return(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
			'order_id' => 'required|exists:orders,id',
			'return_reason' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {

			$order_data = Orders::where('user_id', Auth::user()->id)->where('id', $request->order_id)->first();
			if (isset($order_data) && !empty($order_data)) {
				$date1 = date_format(date_create($order_data->created_at), 'Y-m-d H:i:s');
				$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($date1);
				$diff = abs(round($diff / 86400));
				if ($diff >= 0 && $diff <= 7) {

					$order_data->status = 9;
					$order_data->return_reason = $request->return_reason;
					$order_data->return_at = date('Y-m-d H:i:s');
					try {
						$OrderLog = new OrderLog();
						$OrderLog->order_id = $order_data->id;
						$OrderLog->order_status = 9;
						$OrderLog->order_note = $request->return_reason;
						$OrderLog->save();
						try {
							$order_data->save();

							$success = true;
							$message = "SuccessFully Return Your Order";
						} catch (\Exception $e) {
							//dd($e);
						}
					} catch (\Exception $e) {
						//dd($e);
					}
				} else {
					$message = "Order not Applicable to Return";
				}
			} else {
				$message = "Order not Found";
			}
		}
		return response()->json(["success" => $success, "message" => $message, "data" => $data]);
	}

	public function order_cancel(Request $request)
	{
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
			'order_id' => 'required|exists:orders,id',
			'return_reason' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {

			$order_data = Orders::where('user_id', Auth::user()->id)->where('id', $request->order_id)->first();
			if (isset($order_data) && !empty($order_data)) {

				if ($order_data->status <= 4) {

					$order_data->status = 8;
					$order_data->return_reason = $request->return_reason;
					$order_data->return_at = date('Y-m-d H:i:s');
					try {
						$OrderLog = new OrderLog();
						$OrderLog->order_id = $order_data->id;
						$OrderLog->order_status = 8;
						$OrderLog->order_note = $request->return_reason;
						$OrderLog->save();
						try {
							$order_data->save();

							$success = true;
							$message = "SuccessFully Canceled Your Order";
						} catch (\Exception $e) {
							//dd($e);
						}
					} catch (\Exception $e) {
						//dd($e);
					}
				} else {
					$message = "Order not Applicable to Cancel";
				}
			} else {
				$message = "Order not Found";
			}
		}
		return response()->json(["success" => $success, "message" => $message, "data" => $data]);
	}
}
