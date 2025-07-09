<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Address;

class AddressController extends Controller
{
	
	
	
	
	
	public function add_and_update_address(Request $request) {
		
		 $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
                        'user_id' => 'required|exists:users,id',
                        //'name' => 'required',
                        'contact' => 'required|numeric|digits:10',
                        'address' => 'required',
                        'address2' => 'required',
                        'country' => 'required',
                        'state' => 'required',
                        'city' => 'required',
                        'zipcode' => 'required|numeric|digits_between:1,10',
                    ]);

        if ($validator->fails()) { // validation fails
            $message = $validator->errors()->first();
        }else{
				if(isset($request->address_id) && $request->address_id != null){
					$Address = Address::find($request->address_id);
				}else{
					$Address = new Address();
				}
				
				$Address->user_id = $request->user_id;
				$Address->name = $request->name;
				$Address->contact = $request->contact;
				$Address->address = $request->address;
				$Address->address2 = $request->address2;
				$Address->country = $request->country;
				$Address->state = $request->state;
				$Address->city = $request->city;
				$Address->zipcode = $request->zipcode;
				
				try{
                    $Address->save();
					
					$success = true;
					$message = "Address added successfully";
                }
                catch(\Exception $e){
					//dd($e);
                }
		}
		return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}
	
    public function address_list(Request $request) {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();
		
		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
            'offset' => 'required|numeric',
            'limite' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails()) {
             $message = $validator->errors()->first();
        }else{
			$Address = Address::where('user_id', $request->user_id)
							->skip($request->offset)
							->take($request->limite)
							->get();

			if(isset($Address) && $Address->isNotEmpty()){
				$success = true;
				$message = "Data found";
				$data = $Address;
			}
			else{
				$message = "No data found";
			}
		}

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }
	
	public function remove_address(Request $request) {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();
		
		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
			'address_id' => 'required|exists:addresses,id',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        }else{
			$Address = Address::where('user_id', $request->user_id)->where('id', $request->address_id)->first();

			try{
				$Address->delete();
				
				$success = true;
				$message = "Address removed successfully";
			}
			catch(\Exception $e){
				//dd($e);
			}
		}

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }

   
}
