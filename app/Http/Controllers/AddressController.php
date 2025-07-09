<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use App\Models\Address;

class AddressController extends Controller
{
	public function add_and_update_address(Request $request) {
		
		$auth = true;
		$success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
				'name' => 'required',
				'contact' => 'required|numeric|digits:10',
				'Address' => 'required',
				'address2' => 'required',
				'country' => 'required',
				'state' => 'required',
				'city' => 'required',
				'zipcode' => 'required|numeric|digits_between:1,10',
			]);

        if ($validator->fails()) { // validation fails
            $message = $validator->errors()->first();
        }elseif(!Auth::check()){
			$auth = false;
        }else{
			
				if(isset($request->address_id) && $request->address_id != null){
					$Address = Address::find($request->address_id);
				}else{
					$Address = new Address();
				}
				
				$Address->user_id = Auth::user()->id;
				$Address->name = $request->name;
				$Address->contact = $request->contact;
				$Address->address = $request->Address;
				$Address->address2 = $request->address2;
				$Address->country = $request->country;
				$Address->state = $request->state;
				$Address->city = $request->city;
				$Address->zipcode = $request->zipcode;
				
				try{
                    $Address->save();
					
					$success = true;
					$message = 'Address Add SuccessFully';
					if(isset($request->address_id) && $request->address_id != null){
						$message = 'Address Update SuccessFully';
					}
                }
                catch(\Exception $e){
					//dd($e);
                }
		}
		return response()->json(['auth' => $auth, 'success' => $success, 'message' => $message, 'data' => $data]);
	}
	
    public function address_list(Request $request) {

        if(Auth::check()){
			$Address = Address::where('user_id', Auth::user()->id)->orderBy('created_at','desc')->paginate(12);
			return view('front.account.address.index', compact('Address'));
			
		}else{
			return redirect('/');
		}
    }
	
	public function remove_address(Request $request) {
		$auth = true;
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();
		
		$validator = Validator::make($request->all(), [
			'address_id' => 'required|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        }elseif(!Auth::check()){
			$auth = false;
        }else{
			$Address = Address::where('user_id', Auth::user()->id)->where('id', $request->address_id)->first();

			try{
				$Address->delete();
				
				$success = true;
				$message = "Address remove successfully";
			}
			catch(\Exception $e){
				//dd($e);
			}
		}

        return response()->json(['auth' => $auth, 'success' => $success, 'message' => $message, 'data' => $data]);
    }

   
}
