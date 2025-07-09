<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function wishlist_list(Request $request)
    {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'offset' => 'required|numeric',
            'limite' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } else {
            $Wishlist_data = Product::select('id', 'name', 'slug', 'price', 'brand', 'status')
                // ->with(['getFavourite:id,product_id,user_id'])
                ->where('status', 'Active')
                ->whereHas('getFavourite', function ($query) {
                    $query->where('user_id', getUserId());
                })
                ->skip($request->offset)
                ->take($request->limite)
                ->get();

            foreach ($Wishlist_data as $val) {
                $val->is_fevourit = true;
            }

            $success = true;
            $message = "Data found";
            $data = $Wishlist_data;
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }

    public function add_to_wishlist(Request $request)
    {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data['is_fevourit'] = false;

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) { // validation fails
            $message = $validator->errors()->first();
        } else {
            $check = Wishlist::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->first();
            if (!$check) {
                $Wishlist = new Wishlist();
                $Wishlist->user_id = Auth::user()->id;
                $Wishlist->product_id = $request->product_id;
                $Wishlist->save();

                $data['is_fevourit'] = true;
                $success = true;
                $message = "SuccessFully Added In To Wishlist";
            } else {
                $check->delete();
                $success = true;
                $message = "SuccessFully Remove In To Wishlist";
            }
        }

        return response()->json(["success" => $success, "message" => $message, "data" => $data]);
    }
}
