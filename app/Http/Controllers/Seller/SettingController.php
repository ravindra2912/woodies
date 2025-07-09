<?php

namespace app\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Str;
use Illuminate\Support\Facades\Hash;
use File;
use Image;

use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

//email controller
use App\Http\Controllers\EmailsController;

use App\Models\Setting;


class SettingController extends Controller
{

    public function site_seo()
    {
        $Setting = Setting::select('id', 'seo_title', 'seo_tags', 'seo_description')->first();    
        return view('seller.setting.seo', compact('Setting'));
    }
	
    public function update_site_seo(Request $request, $id)
    {
		$success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'seo_title' => 'required',
            'seo_tags' => 'required',
            'seo_description' => 'required',
        ]);

        if ($validator->fails()) {
           $message = $validator->errors()->first();
        }
        else{
			$Setting = Setting::find($id);
			$Setting->seo_title = $request->seo_title;
			$Setting->seo_tags = $request->seo_tags;
			$Setting->seo_description = $request->seo_description;

			try{
				$Setting->save();
				
				$success = true;
				$message = 'Site SEO Update SuccessFully';
				$data = $Setting;
			}
			catch(\Exception $e){
			}
        }
        return response(["success" => $success, "message" => $message, "data" => $data]);
    }

    
	public function social_links()
    {
        $Setting = Setting::select('id', 'Facebook', 'Instagram', 'LinkedIn', 'YouTube', 'Twitter')->first();    
        return view('seller.setting.social_links', compact('Setting'));
    }
	
	public function update_social_links(Request $request, $id)
    {
		$success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            //'seo_title' => 'required',
            
        ]);

        if ($validator->fails()) {
           $message = $validator->errors()->first();
        }
        else{
			$Setting = Setting::find($id);
			$Setting->Facebook = $request->Facebook;
			$Setting->Instagram = $request->Instagram;
			$Setting->LinkedIn = $request->LinkedIn;
			$Setting->YouTube = $request->YouTube;
			$Setting->Twitter = $request->Twitter;

			try{
				$Setting->save();
				
				$success = true;
				$message = 'Links Update SuccessFully';
				$data = $Setting;
			}
			catch(\Exception $e){
			}
        }
        return response(["success" => $success, "message" => $message, "data" => $data]);
    }
	


	
}
