<?php

namespace App\Http\Controllers\Api;

use URL;
use File;
use App\Models\Faq;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\HomeBanner;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home()
    {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        try{

        $data['category'] = Category::select('id', 'name', 'slug', 'image', 'banner_img')
            ->where('parent_id', null)
            ->where('level', 0)
            ->where('status', 'Active')
            ->orderBy('name', 'ASC')
            ->limit(6)
            ->get();

        $data['product'] = Product::select('id', 'name', 'slug', 'price', 'brand', 'status', 'is_variants')
            ->with(['getFavourite:id,product_id,user_id'])
            ->where('status', 'Active')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $data['fevouriteProduct'] = Product::select('id', 'name', 'slug', 'price', 'brand', 'status', 'is_variants')
            // ->with(['getFavourite:id,product_id,user_id'])
            ->where('status', 'Active')
            ->whereHas('getFavourite', function ($query) {
                $query->where('user_id', getUserId());
            })
            ->limit(4)
            ->get();

        $data['homeBanner'] = HomeBanner::select('id', 'image')
            ->where('status', 'Active')
            ->get()
            ->map(function($banner){
                $banner->image = getImage($banner->image);
                return $banner;
            });


        $success = true;
        $message = "Data found";
        }catch(\Exception $e){
            $message = $e->getMessage();
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }

    public function profile(Request $request)
    {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $user = User::select('id', 'first_name', 'last_name', 'mobile', 'image', 'email')
            ->find(Auth::user()->id);

        if ($user) {
            $user->image = getImage($user->image);

            $success = true;
            $message = "Data found";
            $data = $user;
        } else {
            $message = "No data found";
        }


        return response(["success" => $success, "message" => $message, "data" => $data]);
    }

    public function update_profile(Request $request)
    {
        $userId = Auth::user()->id;
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'contact' => 'required|max:12|unique:users,mobile,' . $userId,
            // 'email' => 'required|email|unique:users,email,' . $userId,
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } else {
            $user = User::find($userId);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->mobile = $request->contact;
            // $user->email = $request->email;

            try {
                $user->save();
                $success = true;
                $message = "Profile updated successfully";
                $data = $user;
            } catch (\Exception $e) {
            }
        }

        return response(["success" => $success, "message" => $message, "data" => $data]);
    }

    public function update_profile_image(Request $request)
    {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);
        try {
            if ($validator->fails()) {
                $message = $validator->errors()->first();
            } else {
                $user = User::find(Auth::user()->id);
                if ($user) {
                    if ($request->hasfile('image')) {
                        $oldimg = $user->image;
                        $imgpath = fileUploadStorage($request->file('image'), 'users_images');
                        $user->image = $imgpath;
                        $user->save();
                        if (isset($oldimg)) {
                            fileRemoveStorage($oldimg);
                        }
                        $success = true;
                        $data['image'] = getImage($user->image);
                        $message = "Image Update SuccessFully";
                    }
                } else {
                    $message = "User not found";
                }
            }
        } catch (\Exception $e) {
            if (isset($imgpath)) {
                fileRemoveStorage($imgpath);
            }
        }

        return response(["success" => $success, "message" => $message, "data" => $data]);
    }

    function changePassword(Request $request)
    {
        try {
            $success = false;
            $message = "Some error occurred. Please try again after sometime";
            $data = array();

            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|min:6|max:20',
                'confirm_password' => 'required|same:new_password'
            ]);

            if ($validator->fails()) {
                $message = $validator->errors()->first();
            } else {
                $user = User::find(Auth::user()->id);
                if ($user) {
                    if (Hash::check($request->old_password, $user->password)) {
                        $user->password = Hash::make($request->new_password);
                        $user->save();
                        $success = true;
                        $message = 'Password change successfully';
                    } else {
                        $message = 'Old password does not match';
                    }
                } else {
                    $message = 'User not found';
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response(["success" => $success, "message" => $message, "data" => $data]);
    }

    public function faqs()
    {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $faqData = Faq::select('id', 'question', 'answer')
            ->orderBy('question', 'ASC')
            ->get();

        if (isset($faqData) && !empty($faqData) && $faqData->isNotEmpty()) {
            $success = true;
            $message = "Data found";
            $data = $faqData;
        } else {
            $message = "No data found";
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }

    public function contactUs(Request $request){
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:50',
            'contatc' => 'required|max:12',
            'email' => 'required|email',
            'message' => 'required|max:500',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } else {
            $insert = new ContactUs();
            $insert->name = $request->name;
            $insert->email = $request->email;
            $insert->phone = $request->contatc;
            $insert->messege = $request->message;
            $insert->save();

            $success = true;
            $message = 'Contact us successfully submitted';
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }
}
