<?php

namespace app\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Str;

use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\OrderStatus;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $ContactUs = ContactUs::orderBy('created_at','desc');
		//filters 
		if($request['search'] != null){ 
			$ContactUs = $ContactUs->where('id','LIKE','%'.$request['search'].'%')
			->Orwhere('phone','LIKE','%'.$request['search'].'%')
			->Orwhere('email','LIKE','%'.$request['search'].'%')
			->Orwhere('messege','LIKE','%'.$request['search'].'%')
			->Orwhere('name','LIKE','%'.$request['search'].'%'); 
			}
		if($request['start_date'] != null){ $ContactUs = $ContactUs->where('created_at','>=',$request['start_date']); }
		if($request['end_date'] != null){ $ContactUs = $ContactUs->where('created_at','<=',date('Y-m-d', strtotime('+1 day', strtotime($request['end_date'])))); }
		//if($request['status'] != null){ $ContactUs = $ContactUs->where('status',$request['status']); }
		
		$ContactUs = $ContactUs->paginate(20);
			
        return view('seller.contactus.index', compact('ContactUs', 'request'));
    }

   
    public function create()
    {
		
		
    }

    public function store(Request $request)
    {
        
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $order = Orders::with(['order_items_data','order_status'])
					->where('user_id', Auth::user()->id)
					->orderBy('created_at','desc')
					->find($id);

       
		$orderstaus = OrderStatus::get();
		$OrderLog = OrderLog::with(['status_data'])->where('order_id', $id)->orderBy('created_at','desc')->get();
                                    
        return view('seller.orders.edit', compact('order','orderstaus','OrderLog'));
    }

    
    public function update(Request $request, $id)
    {
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:categories,id',
            'sub_category' => 'required|exists:categories,id',
            'sub_category2' => 'required|exists:categories,id',
            'product_name' => 'required|max:256',
            'price' => 'required|numeric|gt:0|between:1,9999999999.99',
            'description' => 'required',
            'status' => 'required|In:Active,Inactive',
        ]);
		
		if($request->is_tax_applicable == 'true'){
			$validator = Validator::make($request->all(), [
				'igst' => 'required|numeric|gt:0',
				'cgst' => 'required|numeric|gt:0',
				'sgst' => 'required|numeric|gt:0',
			]);
		}

        if($validator->fails()){ // Validation fails
            $message = $validator->errors()->first();
        }
        else{

            $category_id = $request->category;
            $sub_category_id = $request->sub_category;
            $sub_category2_id = $request->sub_category2;
            $name = trim($request->product_name);
            $slug = Str::slug($name);

            $check_product_name = Product::where('id', '!=', $id)
                                            ->where('user_id', Auth::user()->id)
                                            ->where('slug', $slug)
                                            ->where('category_id', $category_id)
                                            ->where('sub_category_id', $sub_category_id)
                                            ->where('sub_category2_id', $sub_category2_id)
                                           
                                            ->count();

            if($check_product_name == 0){ // Same name product is not exist with same category, sub category and sub category2 so insert it

                $product = Product::whereNull('deleted_at')->find($id);
                $product->category_id = $category_id;
                $product->sub_category_id = $sub_category_id;
                $product->sub_category2_id = $sub_category2_id;
                $product->name = $name;
                $product->slug = $slug;
                $product->price = trim($request->price);
                $product->description = $request->description;
                $product->status = $request->status;
				 $product->is_tax_applicable = $request->is_tax_applicable;
				if($request->is_tax_applicable == 'true'){
					$product->igst = $request->igst;
					$product->cgst = $request->cgst;
					$product->sgst = $request->sgst;
				}
                
                try{
                    $product->save();
                    $success = true;
                    $message =  'Product has been updated successfully';
                }
                catch(\Exception $e){
                }
            }
            else{ // Same product name is exist with same category, sub category and sub category2
                $message = 'Product already exist';
            }
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
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

	 public function change_order_status(Request $request)
    {
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders,id',
            'status' => 'required|exists:order_statuses,id',
        ]);
		
        if($validator->fails()){ // Validation fails
            $message = $validator->errors()->first();
        }
        else{

            $Orders = Orders::find($request->id);
			$Orders->status = $request->status;
			try{
				$OrderLog = new OrderLog();
				$OrderLog->order_id = $Orders->id;
				$OrderLog->order_status = $request->status;
				$OrderLog->save();
				try{
					$Orders->save();
				
					$success = true;
					$message = "Order Status Changed";
				}
				catch(\Exception $e){
					//dd($e);
				}
			}
			catch(\Exception $e){
				//dd($e);
			}
                
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }


}
