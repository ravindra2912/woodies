<?php

namespace App\Http\Controllers\Seller;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::select('id', 'title', 'image', 'background_color', 'status');

            if ($request['status'] != null) {
                $data = $data->where('status', $request['status']);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('img', function ($row) {
                    return '<img src="' . getImage($row->image) . '" class="rounded" style="background:' . $row->background_color . '" height="100" />';
                })

                ->addColumn('action', function ($row) {
                    $html = ' 	<div class="d-flex justify-content-center">
									<a href="' . route('blog.edit', $row->id) . '" class="btn btn-primary tableActionBtn editBtn" title="Edit Blog"><i class="right fas fa-edit"></i></a>
					        		<form action="' . route('blog.destroy', $row->id) . '" id="deleteForm' . $row->id . '" method="post">
										<input type="hidden" name="_token" value="' . csrf_token() . '"> 
    									<input type="hidden" name="_method" value="DELETE">
										<button type="button" class="btn btn-danger tableActionBtn deleteBtn" onclick="deleteBlog(' . $row->id . ')" title="Delete Blog"><i class="right fas fa-trash"></i></button>
									</form>
								</div>';
                    return $html;
                })
                ->rawColumns(['action', 'img'])
                ->make(true);
        }

        return view('seller.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seller.blog.create');
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
        $redirect = route('blog.index');
        try {
            $validator = Validator::make($request->all(), [
                'blog_image' => 'required|mimes:jpg,jpeg,png,svg,webp|max:5120', // 5 MB images
                'title' => 'required|max:100',
                'background_color' => 'required|max:100',
                'description' => 'required',
            ]);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
            } else { // Same category name not exist so insert it

                $imgpath = fileUploadStorage($request->file('blog_image'), 'blog_images');

                $insert = new Blog();

                $insert->title = $request->title;
                $insert->background_color = $request->background_color;
                $insert->description = $request->description;
                $insert->slug = Str::slug($request->title);
                $insert->image = $imgpath;
                $insert->save();
                $success = true;
                $message =  'Blog has been created successfully';
                // Cache::forget('main_testimonail_all');
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
        $data = Blog::find($id);

        return view('seller.blog.edit', compact('data'));
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
        $redirect = route('blog.index');
        try {
            $validator = Validator::make($request->all(), [
                'blog_image' => 'nullable|mimes:jpg,jpeg,png,svg,webp|max:5120', // 5 MB images
                'title' => 'required|max:100',
                'background_color' => 'required',
                'description' => 'required'
            ]);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors();
            } else { // Same category name not exist so insert it

                $update = Blog::find($id);

                if ($request->hasfile('blog_image')) {
                    $oldimg = $update->image;
                    $imgpath = fileUploadStorage($request->file('blog_image'), 'blog_images');
                    $update->image = $imgpath;
                }

                $update->title = $request->title;
                $update->background_color = $request->background_color;
                $update->description = $request->description;
                $update->status = $request->status;
                $update->save();

                // Remove old uploaded image if exist
                if (isset($oldimg)) {
                    fileRemoveStorage($oldimg);
                }

                $success = true;
                $message =  'Blog has been update successfully';
                // Cache::forget('main_testimonail_all');
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
        $delete = Blog::find($id);


        if (isset($delete) && !empty($delete)) {
            try {
                // Remove image from folder if exist
                fileRemoveStorage($delete->image);
                $delete->delete();
                // Cache::forget('main_testimonail_all');
                return redirect()->back()->with('success', 'Blog has been deleted successfully');
            } catch (\Exception $e) {
                $message = $e->getMessage();
                return redirect()->back()->with('danger', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('danger', 'Invalid blog');
        }
    }
}
