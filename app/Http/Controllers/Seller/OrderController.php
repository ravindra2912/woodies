<?php

namespace app\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Str;

use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

//email controller
use App\Http\Controllers\EmailsController;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\OrderStatus;
use App\Models\OrderLog;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        //For Excel export
        if (isset($request->action) && $request->action == 'export') {
            $user_id = null;
            $search = (isset($request['search']) && $request['search'] != null) ? $request['search'] : null;
            $start_date = (isset($request['start_date']) && $request['start_date'] != null) ? $request['start_date'] : null;
            $end_date = (isset($request['end_date']) && $request['end_date'] != null) ? $request['end_date'] : null;
            $status = (isset($request['status']) && $request['status'] != null) ? $request['status'] : null;
            return Excel::download(new OrderExport($user_id, $start_date, $end_date, $status,  $search), 'orders.xlsx');
        }

        $orderLists = Orders::with(['user_data', 'order_status'])
            ->select('orders.*')
            // ->join('orders_items as oi','oi.order_id','orders.id','right')
            // ->join('products as p','p.id','oi.product_id','right')
            ->orderBy('orders.created_at', 'desc');
        if (Auth::user()->role_id != 1) {
            $orderLists = $orderLists->where('p.user_id', Auth::user()->id);
        }
        //filters 
        if ($request['search'] != null) {
            $orderLists = $orderLists->where('orders.id', 'LIKE', '%' . $request['search'] . '%');
        }
        if ($request['start_date'] != null) {
            $orderLists = $orderLists->where('orders.created_at', '>=', $request['start_date']);
        }
        if ($request['end_date'] != null) {
            $orderLists = $orderLists->where('orders.created_at', '<=', date('Y-m-d', strtotime('+1 day', strtotime($request['end_date']))));
        }
        if ($request['status'] != null) {
            $orderLists = $orderLists->where('orders.status', $request['status']);
        }
        if ($request['payment_type'] != null) {
            $orderLists = $orderLists->where('orders.payment_type', $request['payment_type']);
        }
        if ($request['payment_status'] != null) {
            $orderLists = $orderLists->where('orders.payment_status', $request['payment_status']);
        }

        $orderLists = $orderLists->paginate(20);

        //dd($request['payment_status']);

        //get all status
        $orderstaus = OrderStatus::get();


        foreach ($orderstaus as $val) {
            $query = Orders::where('orders.status', $val->id)
                ->join('orders_items as oi', 'oi.order_id', '=', 'orders.id')
                ->join('products as p', 'p.id', '=', 'oi.product_id');

            if (Auth::user()->role_id != 1) {
                $query->where('p.user_id', Auth::user()->id);
            }

            // Count unique orders
            $val->orders = $query->distinct('orders.id')->count('orders.id');
        }
        //dd($orderstaus);
        return view('seller.orders.index', compact('orderLists', 'orderstaus', 'request'));
    }


    public function create() {}

    public function store(Request $request) {}

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $order = Orders::with(['seller_order_items_data', 'order_status'])
            //->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->find($id);

        //sent_order_email($id);


        $orderstaus = OrderStatus::get();
        $OrderLog = OrderLog::with(['status_data'])->where('order_id', $id)->orderBy('created_at', 'desc')->get();


        return view('seller.orders.edit', compact('order', 'orderstaus', 'OrderLog'));
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

        if ($request->is_tax_applicable == 'true') {
            $validator = Validator::make($request->all(), [
                'igst' => 'required|numeric|gt:0',
                'cgst' => 'required|numeric|gt:0',
                'sgst' => 'required|numeric|gt:0',
            ]);
        }

        if ($validator->fails()) { // Validation fails
            $message = $validator->errors()->first();
        } else {

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

            if ($check_product_name == 0) { // Same name product is not exist with same category, sub category and sub category2 so insert it

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
                if ($request->is_tax_applicable == 'true') {
                    $product->igst = $request->igst;
                    $product->cgst = $request->cgst;
                    $product->sgst = $request->sgst;
                }

                try {
                    $product->save();
                    $success = true;
                    $message =  'Product has been updated successfully';
                } catch (\Exception $e) {
                }
            } else { // Same product name is exist with same category, sub category and sub category2
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

        if (isset($product) && !empty($product) && isset($product->id)) {
            try {
                $product->delete();
                return redirect()->back()->with('success', 'Product has been deleted successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Some error occurred. Please try again after sometime');
            }
        } else {
            return redirect()->back()->with('danger', 'Invalid product');
        }
    }

    public function change_order_details(Request $request)
    {
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders,id',
            'status' => 'required|exists:order_statuses,id',
            'payment_status' => 'required',
            'payment_type' => 'required',
            'delivery_date' => 'nullable|date',
        ]);

        if ($validator->fails()) { // Validation fails
            $message = $validator->errors()->first();
        } else {
            try {
                $Orders = Orders::find($request->id);
                $Oldsatus = $Orders->status;

                //dd($OldOrders);

                if ($request->delivery_date != null) {
                    $Orders->delivery_date = date_format(date_create($request->delivery_date), 'Y-m-d H:i:s ');
                }

                if ($request->status == 10 && $Orders->status != 10) {
                    $Orders->return_receive_at = date('Y-m-d H:i:s');
                }

                $Orders->status = $request->status;
                $Orders->payment_status = $request->payment_status;
                $Orders->payment_type = $request->payment_type;
                $Orders->save();

                if ($request->status != $Oldsatus) {
                    $OrderLog = new OrderLog();
                    $OrderLog->order_id = $Orders->id;
                    $OrderLog->order_status = $request->status;
                    $OrderLog->save();
                    sent_order_email($Orders->id);
                }

                $success = true;
                $message = "Order Update SuccessFully";
            } catch (\Exception $e) {
                //dd($e);
            }
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }

    public function change_order_address(Request $request)
    {
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders,id',
            'name' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'address2' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zipcode' => 'required',
        ]);

        if ($validator->fails()) { // Validation fails
            $message = $validator->errors()->first();
        } else {
            try {
                $Orders = Orders::find($request->id);
                $Orders->name = $request->name;
                $Orders->contact = $request->contact;
                $Orders->address = $request->address;
                $Orders->address2 = $request->address2;
                $Orders->country = $request->country;
                $Orders->state = $request->state;
                $Orders->city = $request->city;
                $Orders->zipcode = $request->zipcode;
                $Orders->save();

                $success = true;
                $message = "Order Address Update SuccessFully";
            } catch (\Exception $e) {
                //dd($e);
            }
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }



    public function order_bulk_action(Request $request)
    {
        $success = false;
        $message = "Some error occurred. Please try again after sometime";
        $data = array();

        $validator = Validator::make($request->all(), [
            'bulk_status' => 'required',
            'orders' => 'required',
        ]);

        if ($validator->fails()) { // Validation fails
            $message = $validator->errors()->first();
        } else {
            $request->orders = explode(',', $request->orders);
            foreach ($request->orders as $val) {
                $Orders = Orders::find($val);
                if (isset($Orders) && !empty($Orders->id)) {
                    $Orders->status = $request->bulk_status;
                    try {
                        $OrderLog = new OrderLog();
                        $OrderLog->order_id = $Orders->id;
                        $OrderLog->order_status = $request->bulk_status;
                        $OrderLog->save();

                        try {
                            $Orders->save();
                            sent_order_email($Orders->id);
                            $success = true;
                            $message = "Order Status Changed";
                        } catch (\Exception $e) {
                            //dd($e);
                        }
                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }
            }
        }

        return response()->json(['success' => $success, 'message' => $message, 'data' => $data]);
    }
}
