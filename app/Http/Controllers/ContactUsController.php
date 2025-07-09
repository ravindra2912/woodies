<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        return view('front.contact_us');
    }
	
	public function store(Request $request){
		 $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
			'name' => 'required|max:100',
			'email' => 'required|email|max:100',
            'phone' => 'required|numeric|digits:10',
            'subject' => 'required',
            'messege' => 'required',
            
        ]);
		
		if($validator->fails()){ // Validation fails
            $message = $validator->errors()->first();
        }
        else{
			$ContactUs = new ContactUs();
			$ContactUs->name = $request->name;
			$ContactUs->email = $request->email;
			$ContactUs->website = $request->website;
			$ContactUs->phone = $request->phone;
			$ContactUs->type = $request->subject;
			$ContactUs->messege = $request->messege;
			
			try{
				$ContactUs->save();
				$success = true;
				$message =  'Contact Added Successfully';
			}
			catch(\Exception $e){
				$message = $e->getMessage();
			}
		}

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
	}
	
	
}
