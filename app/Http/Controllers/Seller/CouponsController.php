<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use Validator;
use Auth;
use File;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;

class CouponsController extends Controller
{
    public function index(){
        $Coupon = Coupon::orderBy('id','asc')->where('user_id', Auth::user()->id)->get();
		
        return view('seller/Coupons/index')->with(compact('Coupon'));
    }

    public function create(){
        return view('seller/Coupons/create');
    }

    public function store(Request $request){
		
		$success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();
		
		$val = [
			'coupon_code'=>'required',
			'type'=>'required',
			//'minimum_requrment_type'=>'required',
			'active_date'=>'required|date',
			//'active_time'=>'required',
			'end_date'=>'required|date|after_or_equal:active_date',
			//'end_time'=>'required',
		];
		
		if($request['type'] == 1){
			$val['coupon_percent'] = 'required|numeric|between:0,100';
		}else if($request['type'] == 2){
			$val['coupon_amount'] = 'required|numeric|gt:1';
		}
		
		/*if($request['minimum_requrment_type'] == 1){
			$val['minimum_requrment_amt'] = 'required|numeric|gt:1';
		}else if($request['minimum_requrment_type'] == 2){
			$val['minimum_requrment_qty'] = 'required|numeric|gt:1';
		}
		
		if(isset($request['is_coupon_limit']) && $request['is_coupon_limit'] == 1){
			$val['coupon_limit'] = 'required'; 
		} */
		
		$validator = Validator::make($request->all(), $val);
		if($validator->fails()){ // Validation fails
            $message = $validator->errors()->first();
        }else{
			$Coupon = new Coupon;
			
			if($request['type'] == 1){
				$Coupon->coupon_percent = $request['coupon_percent'];
			}else if($request['type'] == 2){
				$Coupon->coupon_amount = $request['coupon_amount'];
			}
			
			/*if($request['minimum_requrment_type'] == 1){
				$Coupon->minimum_requrment = $request['minimum_requrment_amt'];
			}else if($request['minimum_requrment_type'] == 2){
				$Coupon->minimum_requrment = $request['minimum_requrment_qty'];
			}
			
			if(isset($request['is_coupon_limit']) && $request['is_coupon_limit'] == 1){
				$Coupon->is_coupon_limit = $request['is_coupon_limit'];
				$Coupon->coupon_limit = $request['coupon_limit'];
			}
			
			if(isset($request['once_per_user']) && $request['once_per_user'] == 1){
				$Coupon->once_per_user = $request['once_per_user'];
			}
			
			if($request['show_in_list'] == 1){
				$Coupon->show_in_list = $request['show_in_list'];
			} */
			
            $Coupon->coupon_code = $request['coupon_code'];
            $Coupon->user_id = Auth::user()->id;
			
			$Coupon->coupon_type = $request['type'];
			//$Coupon->minimum_requrment_type = $request['minimum_requrment_type'];
			$Coupon->active_date = $request['active_date'];
			//$Coupon->active_time = $request['active_time'];
			$Coupon->end_date = $request['end_date'];
			//$Coupon->end_time = $request['end_time'];
			
			try {
				$Coupon->save();
				
				$success = true;
                $message =  "Coupon has been created successfully";
			} catch(\Illuminate\Database\QueryException $e){ 
				$message = $e->getMessage();
			}
		}
		 //$message = $request['active_date'];
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);  
    }

    public function edit($id){
         $Coupons = Coupon::find($id);
		 $discounted_products = Product::where('user_id', Auth::user()->id)->where('coupon_id', $Coupons->id)->whereNull('deleted_at')->orderBy('created_at','ASC')->get();
         
		$categoryData = Category::get(); 
		$data = compact('Coupons','discounted_products','categoryData');
         return view('seller/Coupons/edit')->with($data);
     }

     public function updates(Request $request, $id){
		 
		$success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();
		 
        $val = [
			'coupon_code'=>'required',
			'type'=>'required',
			//'minimum_requrment_type'=>'required',
			'active_date'=>'required|date',
			//'active_time'=>'required',
			'end_date'=>'required|date|after_or_equal:active_date',
			//'end_time'=>'required',
		];
		
		if($request['type'] == 1){
			$val['coupon_percent'] = 'required|numeric|between:0,100';
		}else if($request['type'] == 2){
			$val['coupon_amount'] = 'required|numeric|gt:1';
		}
		
		/*if($request['minimum_requrment_type'] == 1){
			$val['minimum_requrment_amt'] = 'required|numeric|gt:1';
		}else if($request['minimum_requrment_type'] == 2){
			$val['minimum_requrment_qty'] = 'required|numeric|gt:1';
		}
		
		if(isset($request['is_coupon_limit']) && $request['is_coupon_limit'] == 1){
			$val['coupon_limit'] = 'required';
		} */
		
		$validator = Validator::make($request->all(), $val);
		if($validator->fails()){ // Validation fails
            $message = $validator->errors()->first();
        }else{
			$Coupon = Coupon::find($id);
			
			if($request['type'] == 1){
				$Coupon->coupon_percent = $request['coupon_percent'];
			}else if($request['type'] == 2){
				$Coupon->coupon_amount = $request['coupon_amount'];
			}
			
			/*if($request['minimum_requrment_type'] == 1){
				$Coupon->minimum_requrment = $request['minimum_requrment_amt'];
			}else if($request['minimum_requrment_type'] == 2){
				$Coupon->minimum_requrment = $request['minimum_requrment_qty'];
			}
			
			$Coupon->is_coupon_limit = 0;
			if(isset($request['is_coupon_limit']) && $request['is_coupon_limit'] == 1){
				$Coupon->is_coupon_limit = $request['is_coupon_limit'];
				$Coupon->coupon_limit = $request['coupon_limit'];
			}
			
			$Coupon->once_per_user = 0;
			if(isset($request['once_per_user']) && $request['once_per_user'] == 1){
				$Coupon->once_per_user = $request['once_per_user'];
			}
			
			$Coupon->show_in_list = 0;
			if($request['show_in_list'] == 1){
				$Coupon->show_in_list = $request['show_in_list'];
			}*/
			
            $Coupon->coupon_code = $request['coupon_code'];
			
			
			$Coupon->coupon_type = $request['type'];
			//$Coupon->minimum_requrment_type = $request['minimum_requrment_type'];
			$Coupon->active_date = $request['active_date'];
			//$Coupon->active_time = $request['active_time'];
			$Coupon->end_date = $request['end_date'];
			//$Coupon->end_time = $request['end_time'];
			$Coupon->status = $request['status'];
			
			try {
				$Coupon->save();
				
				$success = true;
                $message =  "Coupon has been created successfully";
			} catch(\Illuminate\Database\QueryException $e){ 
				$message = $e->getMessage();
			}
			
		}
		
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);  

    }

	public function destroy($id)
    {
        $Coupon = Coupon::where('id', $id)
                            ->where('user_id', Auth::user()->id)
                            ->first();
                                    
        if(isset($Coupon) && !empty($Coupon) && isset($Coupon->id)){
            try{
                $Coupon->delete();
                return redirect()->back()->with('success', 'Coupon has been removed from cart successfully');
            }
            catch(\Exception $e){
                return redirect()->back()->with('danger', 'Some error occurred. Please try again after sometime');
            }
        }
        else{
            return redirect()->back()->with('danger', 'Invalid product');
        }
    }
	
	public function add_product(Request $request){
		$success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();
		
		
		$validator = Validator::make($request->all(), 
			[
			'product_id'=>'required|not_in:,""',
			'coupon_id'=>'required',
			]
		);
		if($validator->fails()){ // Validation fails
            $message = $validator->errors()->first();
        }else{
			$ids = explode(',',$request->product_id);
			for($i = 0; $i<= count($ids) -1; $i++){
				$Product = Product::find($ids[$i]);
				if($Product){
					$Product->coupon_id = $request->coupon_id;
					$Product->save();
					
					$Product = null;
					
					
				}
				
			}
			
				$success = true;
                $message =  "Product has been created successfully";
			
		}
		 //$message = $request['active_date'];
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);  
	}
	
	public function remove_product(Request $request){
		$success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();
		
		$validator = Validator::make($request->all(), 
			[
			'product_id'=>'required',
			'coupon_id'=>'required',
			]
		);
		if($validator->fails()){ // Validation fails
            $message = $validator->errors()->first();
        }else{
			$Product = Product::find($request->product_id);
			$Product->coupon_id = null;
			
			try {
				$Product->save();
				
				$success = true;
                $message =  "Product has been removed successfully";
			} catch(\Illuminate\Database\QueryException $e){ 
				$message = $e->getMessage();
			}
		}
		 //$message = $request['active_date'];
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);  
	}
}
