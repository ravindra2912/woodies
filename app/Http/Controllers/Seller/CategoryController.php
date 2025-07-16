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
use Illuminate\Support\Facades\Cache;
//use App\Models\SubCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryLists = Category::select('id', 'name', 'parent_id', 'status')
            ->with([
                'parentCategory' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->orderBy('name', 'asc')->get();


        return view('seller.category.index', compact('categoryLists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryLists = Category::select('id', 'name')->where('parent_id', null)->orderBy('name', 'asc')->get();
        return view('seller.category.create', compact('categoryLists'));
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
        $redirect = route('category.index');
        try {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|max:60',
                'category_image' => 'required|mimes:jpg,jpeg,png,svg|max:5120', // 5 MB images
                'banner_img' => 'nullable|mimes:jpg,jpeg,png,svg|max:5120', // 5 MB images
            ]);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors()->first();
            } else {
                $name = trim($request->category_name);
                $slug = Str::slug($name);

                $check_category_name = Category::where('parent_id', null)
                    ->where('slug', $slug)
                    ->count();

                if ($check_category_name == 0) { // Same category name not exist so insert it

                    $imgpath = fileUploadStorage($request->file('category_image'), 'category_image');

                    $category = new Category();

                    if ($request->hasfile('banner_img')) {
                        $bannerimgpath = fileUploadStorage($request->file('banner_img'), 'category_image');
                        $category->banner_img = $bannerimgpath;
                    }


                    $category->parent_id = isset($request->parent_id) && !empty($request->parent_id) ? $request->parent_id : null;
                    $category->image = $imgpath;
                    $category->slug = $slug;
                    $category->name = $name;


                    $category->save();
                    $success = true;
                    $message =  'Category has been created successfully';
                    Cache::forget('main_categories_all');
                    Cache::forget('get_home_category');
                } else { // Same category name is exist
                    $message = "Category with this name already exist";
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            // Remove new uploaded image if exist
            if (isset($imgpath)) {
                fileRemoveStorage($imgpath);
            }

            if (isset($bannerimgpath)) {
                fileRemoveStorage($bannerimgpath);
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
        $categoryData = Category::find($id);
        $categoryLists = Category::select('id', 'name')->where('parent_id', null)->orderBy('name', 'asc')->get();

        return view('seller.category.edit', compact('categoryData', 'categoryLists'));
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
        $redirect = route('category.index');

        try {

            $rules = [
                'category_name' => 'required|max:60',
                'banner_img' => 'nullable|mimes:jpg,jpeg,png,svg|max:5120', // 5 MB images
                'status' => 'required|in:Active,Inactive'
            ];

            // Check category image field is empty or not
            if (!empty($request->category_image)) {
                $rules['category_image'] = 'required|mimes:jpg,jpeg,png,svg|max:5120';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { // Validation fails
                $message = $validator->errors()->first();
            } else {

                $name = trim($request->category_name);
                $slug = Str::slug($name);

                $check_category_name = Category::where('id', '!=', $id)
                    ->where('slug', $slug)
                    ->count();

                if ($check_category_name == 0) { // Same category name not exist so update it

                    $category = Category::find($id);

                    if (isset($category) && !empty($category) && isset($category->id)) {

                        if ($request->hasfile('category_image')) {
                            $oldimg = $category->image;
                            $imgpath = fileUploadStorage($request->file('category_image'), 'category_image');
                            $category->image = $imgpath;
                        }

                        if ($request->hasfile('banner_img')) {
                            $oldbannerimgpath = $category->banner_img;
                            $bannerimgpath = fileUploadStorage($request->file('banner_img'), 'category_image');
                            $category->banner_img = $bannerimgpath;
                        }

                        $category->parent_id = isset($request->parent_id) && !empty($request->parent_id) ? $request->parent_id : null;
                        $category->name = $name;
                        $category->slug = $slug;
                        $category->SEO_description = $request->SEO_description;
                        $category->SEO_tags = $request->SEO_tags;
                        $category->status = $request->status;


                        $category->save();

                        // Remove old image from folder if exist
                        if (isset($oldimg) && !empty($oldimg)) {
                            fileRemoveStorage($oldimg);
                        }
                        if (isset($oldbannerimgpath) && !empty($oldbannerimgpath)) {
                            fileRemoveStorage($oldbannerimgpath);
                        }

                        $success = true;
                        $message =  'Category has been updated successfully';
                        Cache::forget('main_categories_all');
                        Cache::forget('get_home_category');
                    } else {
                        $message = 'Invalid category';
                    }
                } else { // Same category name is exist
                    $message = "Category with this name already exist";
                }
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();

            // Remove new uploaded image if exist
            if (isset($imgpath)) {
                fileRemoveStorage($imgpath);
            }
            if (isset($bannerimgpath)) {
                fileRemoveStorage($bannerimgpath);
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
        $cat = Category::find($id);


        if (isset($cat) && !empty($cat) && isset($cat->id)) {
            try {

                $subcat = Category::where('parent_id', $cat->id)->get();
                // Remove image from folder if exist
                fileRemoveStorage($cat->image);
                fileRemoveStorage($cat->banner_img);

                $cat->delete();
                Cache::forget('main_categories_all');
                Cache::forget('get_home_category');
                return redirect()->back()->with('success', 'Category has been deleted successfully');
            } catch (\Exception $e) {
                $message = $e->getMessage();
                return redirect()->back()->with('danger', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('danger', 'Invalid category');
        }
    }

    public function category_name()
    {

        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $categoryData = Category::select('id', 'name')
            ->where('parent_id', 0)
            ->where('level', 0)
            ->where('status', 'Active')

            ->orderBy('name', 'ASC')
            ->get();

        if (isset($categoryData) && !empty($categoryData) && $categoryData->isNotEmpty()) {
            $success = true;
            $message = "Data found";
            $data = $categoryData;
        } else {
            $message = 'Category data not found';
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }
}
