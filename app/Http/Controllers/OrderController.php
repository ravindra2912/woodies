<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
use App\Models\AddToCart;
use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\Coupon;
use App\Models\ProductVariants;
use App\Models\ProductImages;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderLog;
use App\Models\OrderStatus;
use Auth;

//email controller
use App\Http\Controllers\EmailsController;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class OrderController extends Controller
{



	public function place_order(Request $request)
	{

		$auth = true;
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();
		$redirect_url = '';

		$validator = Validator::make($request->all(), [
			// 'address' => 'required|exists:addresses,id',
			'name' => 'required',
			'contact' => 'required|numeric|digits:10',
			'address' => 'required',
			'address2' => 'required',
			'country' => 'required',
			'state' => 'required',
			'city' => 'required',
			'zipcode' => 'required|numeric|digits_between:1,10',
			// 'payment_type' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} elseif (!Auth::check()) {
			$auth = false;
		} elseif (check_cart()['changes']) {
			$message = 'Your Cart Is Updated, Please Check Your Cart!';
		} else {
			$request->payment_type = 1;
			$request->user_id = Auth::user()->id;
			$cart_list = AddToCart::where('user_id', $request->user_id)->with(['product_data'])->get();
			//$data = $cart_list;

			if (isset($cart_list) && $cart_list->isNotEmpty()) {

				$Orders = new Orders();
				$Orders->user_id = $request->user_id;
				$Orders->address_id = null;
				$Orders->name = $request->name;
				$Orders->contact = $request->contact;
				$Orders->address = $request->address;
				$Orders->address2 = $request->address2;
				$Orders->country = $request->country;
				$Orders->state = $request->state;
				$Orders->city = $request->city;
				$Orders->zipcode = $request->zipcode;
				$Orders->payment_type = $request->payment_type;

				try {
					DB::beginTransaction();
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
							// $ProductVariants->qty = $ProductVariants->qty - $cl->quantity;
							// $ProductVariants->save();


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
						$check = check_coupon($request->coupon_code, $request->user_id);
						if ($check && $check['status'] == true) {
							$discount = $check['discount'];
							//$data['free_delivery'] = $check['free_delivery'];
							$Orders->coupon_id = $check['coupon_id'];
							$Orders->coupon_code = $request->coupon_code;
						}
					}


					if (!empty($request)) {
						if (strtoupper(trim($request->country)) == 'INDIA' || strtoupper(trim($request->country)) == 'IN') {
							$Orders->shipping = 90;
						} else {
							$Orders->shipping = 160;
						}
					}


					$Orders->subtotal = $subtotal;
					$Orders->discount = $discount;
					$Orders->tax = $tax;
					$Orders->total = ($subtotal - $discount) + $tax + $Orders->shipping;
					$Orders->save();

					if ($Orders->payment_type == 1) {
						$redirect_url = url('/order/pyamnet/' . Crypt::encrypt($Orders->id));
					} else {
						$redirect_url = url('/order/order_responce/' . Crypt::encrypt($Orders->id));

						$order_data = Orders::with('order_items_data')->where('id', $Orders->id)->first();
						foreach ($order_data->order_items_data as $item) {
							if ($item->Variants_id != null) {
								$ProductVariants = ProductVariants::find($item->Variants_id);
								$ProductVariants->qty = $ProductVariants->qty - $item->quantity;
								$ProductVariants->save();
							} else {
								$Product = Product::find($item->product_id);
								$Product->quantity = $Product->quantity - $item->quantity;
								$Product->save();
							}
						}
					}


					//create log
					$OrderLog = new OrderLog();
					$OrderLog->order_id = $Orders->id;
					$OrderLog->order_status = 1;
					$OrderLog->save();

					//empty card
					AddToCart::where('user_id', $request->user_id)->delete();


					//order data
					$order_data = Orders::where('user_id', $request->user_id)
						->where('id', $Orders->id)
						->with(['order_items_data'])
						->first();

					if (isset($order_data) && !empty($order_data)) {

						$order_data->created_date = date_format(date_create($order_data->created_at), 'Y-m-d H:i:s');

						foreach ($order_data->order_items_data as $pdata) {
							$pdata->image  = asset('uploads/default_images/default_image.png');
							$pi = ProductImages::where('product_id', $pdata->product_id)->orderBy('id', 'asc')->first();
							if (isset($pi) && !empty($pi)) {
								if (file_exists($pi->small_image)) {
									$pdata->image = asset($pi->small_image);
								}
							}
						}
						$data = $order_data;
					}

					$success = true;
					$message = "Order Placed Successfully";
					DB::commit();
				} catch (\Exception $e) {
					$message = $e->getMessage();
					DB::rollback();
				}
			} else {
				$message = "Cart is Empty";
			}
		}
		return response()->json(["auth" => $auth, 'success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect_url]);
	}

	public function pyamnet($id)
	{
		$order_id = Crypt::decrypt($id);
		$order = Orders::with(['user_data'])->find($order_id);
		if ($order->payment_status != 0) {
			return redirect('order/order_responce/' . $id);
		}

		return view('front.order.payment', compact('order'));
	}

	public function order_payment(Request $request)
	{

		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();
		$redirect = route('order.order_responce', Crypt::encrypt($request->order));

		$validator = Validator::make($request->all(), [
			'order' => 'required|exists:orders,id',
			'razorpay_payment_id' => 'required',
			'email' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} else {

			$order_data = Orders::with('order_items_data')->where('id', $request->order)->first();
			if (isset($order_data) && !empty($order_data)) {
				$order_data->payment_transaction_id = $request->razorpay_payment_id;
				$order_data->payment_status = 1;
				$order_data->status = 2;
				$order_data->delivery_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 7 days'));
				$order_data->payment_by = $request->email;

				try {
					$order_data->save();

					$OrderLog = new OrderLog();
					$OrderLog->order_id = $order_data->id;
					$OrderLog->order_status = 2;
					$OrderLog->save();

					foreach ($order_data->order_items_data as $item) {
						if ($item->Variants_id != null) {
							$ProductVariants = ProductVariants::find($item->Variants_id);
							$ProductVariants->qty = $ProductVariants->qty - $item->quantity;
							$ProductVariants->save();
						} else {
							$Product = Product::find($item->product_id);
							$Product->quantity = $Product->quantity - $item->quantity;
							$Product->save();
						}
					}
					sent_order_email($order_data->id);

					$success = true;
					$message = 'Payment Suceess';
				} catch (\Exception $e) {
					dd($e);
				}
			} else {
				$message = "No data found";
			}
		}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
	}

	public function order_responce($id)
	{
		$order_id = Crypt::decrypt($id);
		//dd($order_id);
		$order = Orders::with(['user_data'])->find($order_id);
		return view('front.order.payment_responce', compact('order'));
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

		if (Auth::check()) {

			$order_data = Orders::where('user_id', Auth::user()->id)
				->with(['order_items_data', 'order_status'])
				->OrderBy('created_at', 'desc')
				->paginate(10);
			if (isset($order_data) && !empty($order_data)) {
				foreach ($order_data as $od) {
					$od->created_date = date_format(date_create($od->created_at), 'Y-m-d H:i:s');

					if (isset($od->order_items_data) && !empty($od->order_items_data)) {
						foreach ($od->order_items_data as $item) {
							$pi = ProductImages::where('product_id', $item->product_id)->orderBy('id', 'asc')->first();
							$item->image = getImage(isset($pi->image) ? $pi->image : '');
						}
					}
				}
			}
			return view('front.account.orders.index', compact('order_data'));
		} else {
			return redirect('/');
		}
	}

	public function order_details(Request $request, $id)
	{

		if (Auth::check()) {
			$order_data = Orders::where('user_id', Auth::user()->id)
				->where('id', $id)
				->with(['order_items_data', 'order_logs_status', 'order_status', 'user_data'])
				->first();

			foreach ($order_data->order_items_data as $pdata) {
				$pdata->image  = asset('uploads/default_images/default_image.png');
				$pi = ProductImages::where('product_id', $pdata->product_id)->orderBy('id', 'asc')->first();
				$pdata->image = getImage(isset($pi->image) ? $pi->image : '');
			}

			$OdStatus = OrderStatus::get();
			return view('front.account.orders.details', compact('order_data', 'OdStatus'));
		} else {
			return redirect('/');
		}
	}

	public function cancel_order(Request $request)
	{
		$auth = true;
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'order_id' => 'required|exists:orders,id',
			'cancel_reason' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} elseif (!Auth::check()) {
			$auth = false;
		} else {

			$order_data = Orders::where('user_id', Auth::user()->id)->where('id', $request->order_id)->first();
			if (isset($order_data) && !empty($order_data)) {
				if ($order_data->status <= 4) {

					$order_data->status = 8;
					$order_data->return_reason = $request->cancel_reason;
					$order_data->return_at = date('Y-m-d H:i:s');
					try {
						$OrderLog = new OrderLog();
						$OrderLog->order_id = $order_data->id;
						$OrderLog->order_status = 8;
						$OrderLog->order_note = $request->cancel_reason;
						$OrderLog->save();
						try {
							$order_data->save();
							sent_order_email($order_data->id);
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
		return response()->json(["auth" => $auth, "success" => $success, "message" => $message, "data" => $data]);
	}

	public function order_return(Request $request)
	{
		$auth = true;
		$success = false;
		$message = "Some error occurred. Please try again after sometime";
		$data = array();

		$validator = Validator::make($request->all(), [
			'order_id' => 'required|exists:orders,id',
			'return_reason' => 'required',
		]);

		if ($validator->fails()) { // validation fails
			$message = $validator->errors()->first();
		} elseif (!Auth::check()) {
			$auth = false;
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
							sent_order_email($order_data->id);
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
		return response()->json(["auth" => $auth, "success" => $success, "message" => $message, "data" => $data]);
	}
}
