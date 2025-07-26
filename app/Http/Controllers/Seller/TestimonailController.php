<?php

namespace App\Http\Controllers\Seller;

use Str;
use Auth;
use File;
use Image;
use Validator;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Testimonail;
use Illuminate\Support\Facades\Cache;
//use App\Models\SubCategory;

class TestimonailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Testimonail::select('id', 'name', 'thumbnail_image', 'status')
            ->orderBy('name', 'asc')
            ->get();
        return view('seller.testimonail.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seller.testimonail.create');
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
        $redirect = route('testimonail.index');
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:40',
                'description' => 'required|max:200',
                'video_link' => 'required|max:200',
                'thumbnail_image' => 'required|mimes:jpg,jpeg,png,svg|max:5120', // 5 MB images
            ]);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
            } else { // Same category name not exist so insert it

                $imgpath = fileUploadStorage($request->file('thumbnail_image'), 'testimonail_image');

                $insert = new Testimonail();

                $insert->name = $request->name;
                $insert->description = $request->description;
                $insert->video_link = $request->video_link;
                $insert->thumbnail_image = $imgpath;
                $insert->save();
                $success = true;
                $message =  'Testimonail has been created successfully';
                Cache::forget('main_testimonail_all');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            // Remove new uploaded image if exist
            if (isset($imgpath)) {
                fileRemoveStorage($imgpath);
            }
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Testimonail::find($id);

        return view('seller.testimonail.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();
        $redirect = route('testimonail.index');
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:40',
                'description' => 'required|max:200',
                'video_link' => 'required|max:200',
                'thumbnail_image' => 'nullable|mimes:jpg,jpeg,png,svg|max:5120', // 5 MB images
            ]);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
            } else { // Same category name not exist so insert it

                $update = Testimonail::find($id);

                if ($request->hasfile('thumbnail_image')) {
                    $oldimg = $update->thumbnail_image;
                    $imgpath = fileUploadStorage($request->file('thumbnail_image'), 'testimonail_image');
                    $update->thumbnail_image = $imgpath;
                }

                $update->name = $request->name;
                $update->description = $request->description;
                $update->video_link = $request->video_link;
                $update->status = $request->status;
                $update->save();

                // Remove old uploaded image if exist
                if (isset($oldimg)) {
                    fileRemoveStorage($oldimg);
                }

                $success = true;
                $message =  'Testimonail has been update successfully';
                Cache::forget('main_testimonail_all');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            // Remove new uploaded image if exist
            if (isset($imgpath)) {
                fileRemoveStorage($imgpath);
            }
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Testimonail::find($id);


        if (isset($delete) && !empty($delete)) {
            try {
                // Remove image from folder if exist
                fileRemoveStorage($delete->thumbnail_image);
                $delete->delete();
                Cache::forget('main_testimonail_all');
                return redirect()->back()->with('success', 'Testimonail has been deleted successfully');
            } catch (\Exception $e) {
                $message = $e->getMessage();
                return redirect()->back()->with('danger', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('danger', 'Invalid Testimonail');
        }
    }

}
