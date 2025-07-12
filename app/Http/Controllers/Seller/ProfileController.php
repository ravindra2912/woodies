<?php

namespace app\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
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
            'contact' => 'required|max:12|unique:users,mobile,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'image' => 'nullable|mimes:jpg,jpeg,png,svg|max:5120',
        ]);




        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } else {
            $user = User::find($id);

            if ($request->hasfile('image')) {
                $old_image = $user->image;
                $imgpath = fileUploadStorage($request->file('image'), 'user_images');
                $user->image = $imgpath;
            }


            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->mobile = $request->contact;
            $user->email = $request->email;

            if (isset($request->password) || !empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            try {
                $user->save();

                if (isset($old_image)) {
                    fileRemoveStorage($old_image);
                }

                $success = true;
                $message = 'User Update SuccessFully';
                $data = $user;
            } catch (\Exception $e) {
                $message = $e->getMessage();
                if (isset($imgpath)) {
                    fileRemoveStorage($imgpath);
                }
            }
        }

        return response(["success" => $success, "message" => $message, "data" => $data]);
    }
}
