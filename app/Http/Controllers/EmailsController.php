<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
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
use Mail;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EmailsController extends Controller
{
	
	public function order($id) {
		
			$order = Orders::where('id', $id)
						->with(['order_items_data','order_logs_status', 'order_status', 'user_data'])
						->first();
			
			foreach($order->order_items_data as $pdata){
				$pdata->image  = asset('uploads/default_images/default_image.png');
				$pi = ProductImages::where('product_id', $pdata->product_id)->orderBy('id', 'asc')->first();
				if(isset($pi) && !empty($pi)){
					if(file_exists($pi->thumbnail_image)) { $pdata->image = asset($pi->thumbnail_image); }
				}
			}
			
			$OdStatus = OrderStatus::get();
			
			$estaust = array(2, 5, 6, 7, 8, 9, 10);
			
			if(isset($order) && !empty($order) && in_array($order->status, $estaust)){
				$SubscriptionUrl = 'SubscriptionUrl';
				//$html = view('emails.OrderEmail', compact('order', 'OdStatus', 'SubscriptionUrl'))->render();
				//echo($html);
				//die;
				
				if(isset($order->user_data) && !empty($order->user_data) && !empty($order->user_data->email)){
					$info['subject'] = 'Order Confirmation';
					if(isset($order->order_status) && !empty($order->order_status)){ $info['subject'] = $order->order_status->email_subject; }
					//$info['to'] = $order->user_data->email;
					$info['to'] = 'goswamirvi@gmail.com';
					
					try{
						Mail::send('emails.OrderEmail', compact('order', 'OdStatus', 'SubscriptionUrl'), function($message) use ($info){
							$message->to($info['to']);
							$message->subject($info['subject']);
						});
					}
					catch(\Exception $e){
						//$e->getMessage();
						return false;
					}
				}
			}
			return true;
		
    }
	
	
}
