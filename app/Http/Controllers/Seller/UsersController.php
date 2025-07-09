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


class UsersController extends Controller
{
    public function index(Request $request)
    {
		
        $User = User::orderBy('created_at','desc');
		//filters 
		if($request['search'] != null){ 
			$User = $User->where('id','LIKE','%'.$request['search'].'%')->Orwhere('first_name','LIKE','%'.$request['search'].'%')->Orwhere('last_name','LIKE','%'.$request['search'].'%'); 
		}
		if($request['start_date'] != null){ $User = $User->where('created_at','>=',$request['start_date']); }
		if($request['end_date'] != null){ $User = $User->where('created_at','<=',date('Y-m-d', strtotime('+1 day', strtotime($request['end_date'])))); }
		
		$User = $User->paginate(20);
					

        return view('seller.users.index', compact('User', 'request'));
    }

   
    public function create()
    {
       //
    }

    public function store(Request $request)
    {
       //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $User = User::find($id);
        return view('seller.users.edit', compact('User'));
    }

    
    public function update(Request $request, $id)
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

            if ($request->hasfile('image')) {
                $oldimg = $user->image;
                $imgpath = fileUploadStorage($request->file('image'), 'users_images');
                $user->image = $imgpath;
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
				
                if (isset($oldimg) && !empty($oldimg)) {
                    fileRemoveStorage($oldimg);
                }
				$success = true;
				$message = 'User Update SuccessFully';
				$data = $user;
			}
			catch(\Exception $e){
                $message = $e->getMessage();
                fileRemoveStorage($imgpath);			}
           
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
