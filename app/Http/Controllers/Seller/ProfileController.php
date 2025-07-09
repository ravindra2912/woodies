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

use App\Models\User;


class ProfileController extends Controller
{

    public function profile()
    {
        $User = User::find(Auth::user()->id);    
        return view('seller.profile.profile', compact('User'));
    }

    
    public function updateprofile(Request $request, $id)
    {
         $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'contact' => 'required|max:12|unique:users,mobile,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:5120',
        ]);
		
		


        if ($validator->fails()) {
           $message = $validator->errors()->first();
        }
        else{
			$user = User::find($id);
				
			if($request->hasfile('image')){
				$old_big_image_name = $user->image;
				
				 // create folder if not exist
				$dir = 'uploads/user_images';
				if(!File::exists($dir)) {
					File::makeDirectory($dir);
				}
				
				$imagefile = $request->file('image');
				
				$uniq = uniqid()."-".time();
				$big_image_name = $uniq."-250-250".".".strtolower($imagefile->getClientOriginalExtension());
				$destinationPath = public_path('/'.$dir);
				$img = Image::make($imagefile->path());
				$img->resize(250, 250, function ($constraint) {
					$constraint->aspectRatio();
				})->save($destinationPath.'/'.$big_image_name);
				
				$user->image = $dir.'/'.$big_image_name;
			}

		
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->mobile = $request->contact;
			$user->email = $request->email;
			
			if(isset($request->password) || !empty($request->password)){
				$user->password = Hash::make($request->password);
			}

			try{
				$user->save();
				
				if(isset($old_big_image_name) && !empty($old_big_image_name) && File::exists($old_big_image_name)) { unlink($old_big_image_name); }

				$success = true;
				$message = 'User Update SuccessFully';
				$data = $user;
			}
			catch(\Exception $e){
				if(isset($big_image_name) && !empty($big_image_name) && File::exists($dir.'/'.$big_image_name)) {  unlink($dir.'/'.$big_image_name); }
			}
           
        }

        return response(["success" => $success, "message" => $message, "data" => $data]);
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)
                            ->where('user_id', Auth::user()->id)
                            ->first();
                                    
        if(isset($product) && !empty($product) && isset($product->id)){
            try{
                $product->delete();
                return redirect()->back()->with('success', 'Product has been deleted successfully');
            }
            catch(\Exception $e){
                return redirect()->back()->with('danger', 'Some error occurred. Please try again after sometime');
            }
        }
        else{
            return redirect()->back()->with('danger', 'Invalid product');
        }
    }

	


	
}
