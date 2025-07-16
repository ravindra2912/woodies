<?php

namespace App\Http\Controllers\Seller;

use Str;
use Auth;
use File;
use Image;
use Validator;
use App\Models\Category;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
//use App\Models\SubCategory;

class HomeBannerController extends Controller
{
    public function index()
    {
        $HomeBanner = HomeBanner::orderBy('created_at', 'DESC')->get();
        return view('seller.homebanner.index', compact('HomeBanner'));
    }

    public function create()
    {
        return view('seller.homebanner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [

            'image' => 'required|mimes:jpg,jpeg,png,svg,webp|max:5120', // 5 MB images
            'redirect_url' => 'required',
        ]);

        if ($validator->fails()) { // Validation fails
            $message = $validator->errors()->first();
        } else {
            $imgpath = fileUploadStorage($request->file('image'), 'homebanner');

            $HomeBanner = new HomeBanner();
            $HomeBanner->image = $imgpath;
            $HomeBanner->redirect_url = $request->redirect_url;

            try {
                $HomeBanner->save();
                $success = true;
                $message =  'Category has been created successfully';
                Cache::forget('banner_all');
            } catch (\Exception $e) {
                $message = $e->getMessage();
                // Remove new uploaded image if exist
                fileRemoveStorage($imgpath);
            }
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }


    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $HomeBanner = HomeBanner::where('id', $id)->first();

        return view('seller.homebanner.edit', compact('HomeBanner'));
    }


    public function update(Request $request, $id)
    {
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $rules = [
            'redirect_url' => 'required',
            'status' => 'required|in:Active,Inactive'
        ];

        // Check category image field is empty or not
        if (!empty($request->image)) {
            $rules['image'] = 'required|mimes:jpg,jpeg,png,svg,webp|max:5120';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) { // Validation fails
            $message = $validator->errors()->first();
        } else {
            $HomeBanner = HomeBanner::where('id', $id)->first();

            if (isset($HomeBanner) && !empty($HomeBanner) && isset($HomeBanner->id)) {


                if ($request->hasfile('image')) {
                    $oldimg = $HomeBanner->image;
                    $imgpath = fileUploadStorage($request->file('image'), 'homebanner');
                    $HomeBanner->image = $imgpath;
                }
                
                $HomeBanner->redirect_url = $request->redirect_url;
                $HomeBanner->status = $request->status;

                try {
                    $HomeBanner->save();

                    // Remove old image from folder if exist
                    if (isset($oldimg) && !empty($oldimg)) {
                        fileRemoveStorage($oldimg);
                    }

                    $success = true;
                    $message =  "Banner has been updated successfully";
                    Cache::forget('banner_all');
                } catch (\Exception $e) {

                    // Remove new uploaded image if exist
                    fileRemoveStorage($imgpath);
                }
            } else {
                $message = "Banner not found";
            }
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = HomeBanner::where('id', $id)->first();


        if (isset($cat) && !empty($cat) && isset($cat->id)) {
            try {

                // Remove image from folder if exist
                fileRemoveStorage($cat->image);

                $cat->delete();
                Cache::forget('banner_all');
                return redirect()->back()->with('success', 'Banner has been removed successfully');
            } catch (\Exception $e) {
                //return redirect()->back()->with('danger', 'Some error occurred. Please try again after sometime');
                return redirect()->back()->with('danger', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('danger', 'Banner invalid');
        }
    }
}
