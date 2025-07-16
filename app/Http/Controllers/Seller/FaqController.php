<?php

namespace App\Http\Controllers\Seller;

use Str;
use Auth;
use App\Models\Faq;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

//use App\Models\SubCategory;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::get();
        return view('seller.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seller.faq.create');
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
            'answer' => 'required',
            'question' => 'required',
        ]);

        try {
            if ($validator->fails()) { // Validation fails
                $message = $validator->errors()->first();
            } else {
                $insert = new Faq();
                $insert->answer = $request->answer;
                $insert->question = $request->question;
                $insert->save();
                $success = true;
                $message =  'Faq has been created successfully';
                Cache::forget('faqs_all');
            }
        } catch (\Exception $e) {
            //$message = $e->getMessage();
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
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

        $faq = Faq::where('id', $id)->first();

        return view('seller.faq.edit', compact('faq'));
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

        $validator = Validator::make($request->all(), [
            'answer' => 'required',
            'question' => 'required',
        ]);

        try {
            if ($validator->fails()) { // Validation fails
                $message = $validator->errors()->first();
            } else {

                $update = Faq::find($id);
                $update->answer = $request->answer;
                $update->question = $request->question;
                $update->save();
                $success = true;
                $message = "FAQ has been updated successfully";
                Cache::forget('faqs_all');
            }
        } catch (\Exception $e) {
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
        $faq = Faq::find($id);

        if ($faq) {
            try {

                $faq->delete();
                Cache::forget('faqs_all');
                return redirect()->back()->with('success', 'FAQ has been removed successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Some error occurred. Please try again after sometime');
            }
        } else {
            return redirect()->back()->with('danger', 'FAQ invalid');
        }
    }
}
