<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use App\Models\AddToCart;
use App\Models\ProductVariants;
use App\Models\Product;
use App\Models\Address;
use App\Models\Coupon;

class ChechOutController extends Controller
{
    
	public function index(Request $request) {
		if(!Auth::check()){
           return redirect('/');
        }
		$carts = AddToCart::where('user_id', Auth::user()->id)->get();
		if(isset($carts) && !empty($carts) && count($carts) > 0){
			return view('front.checkout.checkout');
		}else{
			 return redirect('/');
		}		
    }
	
	public function render_summary(Request $request){
		
		if(!isset(Auth::user()->id) && empty(Auth::user()->id)){
            return redirect('/');
        }
        else{
			
			check_cart();
			
			$success = true;
			$message = "Some error occurred. Please try again after sometime";
			$data = array();
			
			$summary['subtotle'] = 0;
			$summary['tax'] = 0;
			$summary['igst'] = 0;
			$summary['cgst'] = 0;
			$summary['sgst'] = 0;
			$summary['discount'] = 0;
			$summary['delivery'] = 0;
			$summary['totle'] = 0;
			$summary['cart_count'] = 0;

            $carts = AddToCart::where('user_id', Auth::user()->id)
							->with(['product_data', 'images_data'])
							->get();
							
			foreach($carts as $cdata){
				
				$summary['cart_count'] += $cdata->quantity;
				$product_amount = 0;
				if($cdata->Variants_id != ''){
					$chack_variant = ProductVariants::find($cdata->Variants_id);
					if($chack_variant){
						$cdata->amount =  $chack_variant->amount;
						$product_amount += $chack_variant->amount * $cdata->quantity;
					}else{
						$cdata->amount =  $cdata->product_data->price;
						$product_amount += $cdata->product_data->price * $cdata->quantity;
					}
				}else{
					$cdata->amount =  $cdata->product_data->price;
					$product_amount += $cdata->product_data->price * $cdata->quantity;
				}
				
				if($cdata->product_data->is_tax_applicable == "true"){
					$summary['igst'] += ($product_amount * $cdata->product_data->igst) / 100;
					$summary['cgst'] += ($product_amount * $cdata->product_data->cgst) / 100;
					$summary['sgst'] += ($product_amount * $cdata->product_data->sgst) / 100;
				}
				
				 
				$summary['subtotle'] += $product_amount;
				
				$cdata->image  = asset('uploads/default_images/default_image.png');
				if(isset($cdata->images_data) && count($cdata->images_data) > 0){
					if(file_exists($cdata->images_data[0]->thumbnail_image))
					{
						$cdata->image = asset($cdata->images_data[0]->thumbnail_image); 
					}
				}
			}
			$summary['tax'] = $summary['igst'];
			
			//coupons 
			$coupon = array();
			if(!empty($request->coupan_code)){
				$coupon = check_coupon($request->coupan_code, Auth::user()->id);
				$summary['discount'] = $coupon['discount'];
			}
			
			
			//address
			$address = array();
			if(!empty($request->address)){
				$address = Address::find($request->address);
			}
			
			if(!empty($address)){
				if(strtoupper(trim($address->country)) == 'INDIA' || strtoupper(trim($address->country)) == 'IN'){
					$summary['delivery'] = 90;
				}else{
					$summary['delivery'] = 160;
				}
			}
			
			$summary['totle'] = ($summary['subtotle'] - $summary['discount']) + $summary['tax'] + $summary['delivery'];
			
            $html = view('front.checkout.rendarSummary', compact('carts', 'summary', 'request', 'coupon', 'address'))->render();
		
			return response()->json(['success' => $success, 'message'=>$message , 'data' => $html,  ]);
        }
		
	}
}
