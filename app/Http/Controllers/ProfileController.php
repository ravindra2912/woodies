<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use File;
use Image;
use URL;
use Hash;
use App\Models\Category;
use App\Models\User;

class ProfileController extends Controller
{

    public function profile(Request $request)
    {

        if (!Auth::check()) {
            return redirect('/');
        }

        $user = User::whereNull('deleted_at')->find(Auth::user()->id);
        return view('front.account.profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $auth = true;
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'mobile_no' => 'required|max:12|unique:users,mobile,' . Auth::user()->id,
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:5120',
        ]);




        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } elseif (!Auth::user()) {
            $auth = false;
        } else {

            $user = User::find(Auth::user()->id);

            if ($request->hasfile('image')) {
                $oldimg = $user->image;
                $imgpath = fileUploadStorage($request->file('image'), 'user_images');
                $user->image = $imgpath;
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->mobile = $request->mobile_no;
            $user->email = $request->email;

            try {
                $user->save();

                if (isset($oldimg) && !empty($oldimg)) {
                    fileRemoveStorage($oldimg);
                }

                $success = true;
                $message = "Profile has been updated successfully";
                $data = $user;
            } catch (\Exception $e) {
                fileRemoveStorage($imgpath);
            }
        }

        return response(["success" => $success, "message" => $message, "data" => $data]);
    }

    function password()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        return view('front.account.changepassword');
    }

    public function change_password(Request $request)
    {
        $auth = true;
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:15',
            'confirm_password' => 'required|min:8|max:15|same:password',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } else if (!Auth::check()) {
            $auth = false;
        } else {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);

            try {
                $user->save();
                $success = true;
                $message = 'Passwoed Change SuccessFully';
                $data = $user;
            } catch (\Exception $e) {
            }
        }

        return response(["auth" => $auth, "success" => $success, "message" => $message, "data" => $data]);
    }

    public function update_profile_image(Request $request)
    {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } else {

            $dir = 'uploads/user_images';
            if (!File::exists($dir)) {
                File::makeDirectory($dir);
            }

            $uniq = uniqid() . "-" . time();
            $destinationPath = public_path('/' . $dir);
            $image = $request->image;  // your base64 encoded

            //image info
            $parts        = explode(";base64,", $image);
            $imageparts   = explode("image/", @$parts[0]);
            $imagetype    = $imageparts[1];
            $imagebase64  = base64_decode($parts[1]);

            $imageName = $uniq . "." . $imagetype;
            if (file::put($destinationPath . '/' . $imageName, $imagebase64)) {
                $user = User::find($request->user_id);
                $old_img = $user->image;
                $user->image = $dir . '/' . $imageName;

                try {
                    $user->save();
                    if (File::exists($old_img)) {
                        unlink($old_img);
                    }
                    $success = true;
                    $message = "Image Update SuccessFully";
                } catch (\Exception $e) {
                    if (File::exists($dir . '/' . $imageName)) {
                        unlink($dir . '/' . $imageName);
                    }
                }
            } else {
                $message = "Image Update Fail";
            }
        }

        return response(["success" => $success, "message" => $message, "data" => $data]);
    }
}
