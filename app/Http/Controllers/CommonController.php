<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use PDF; 
use Carbon\Carbon;
use App\Models\AddToCart;
use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\Coupon;
use App\Models\ProductVariants;
use App\Models\ProductImages;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderLog;
use App\Models\OrderStatus;
use App\Models\Category;
use App\Models\Wishlist;


class CommonController extends Controller
{
	public function __construct()
    {
        //$this->middleware('auth');
    }
	
	public function get_search_result(Request $request) {
		$html = '';
		$limite = 10;
		
		$Category = Category::Where('name', 'like', '%' . $request->text . '%')->take(5)->whereNull('deleted_at')->get();
		$limite = $limite - count($Category);
		$Product = Product::Where('name', 'like', '%' . $request->text . '%')->take($limite)->where('status', 'Active')->get();
		$Product = $Category->merge($Product);
		
		
		if(isset($Product) && !empty($Product) && count($Product) > 0 && !empty($request->text)){
			foreach($Product as $val){
				$url = url('/products?category='.$val->slug);
				if($val->getTable() == 'products'){
					$url = url('/products/'.$val->slug);
				}
				$html .= '
					<div class="item">
						<a href="'. $url .'">'.$val->name.'</a>
					</div>
				';
			}
		}else{
			$html = '
					<div class="item">
						<a href="#">No Result Found </a>
					</div>
				';
		}
		
        return response()->json([  'html'=>$html]);
    }

   public function pdf_invoice($id){
		$order_data = Orders::where('id', $id)
					->with(['order_items_data','order_logs_status', 'order_status', 'user_data'])
					->first();
		if(isset($order_data->order_items_data) && !empty($order_data->order_items_data) && count($order_data->order_items_data) > 0){
			foreach($order_data->order_items_data as $pdata){
				$pdata->image  = config('const.site_setting.logo');
				$pi = ProductImages::where('product_id', $pdata->product_id)->orderBy('id', 'asc')->first();
				if(isset($pi) && !empty($pi)){
					if(file_exists($pi->thumbnail_image)) { $pdata->image = asset($pi->thumbnail_image); }
				}
			}
		}
		
		$OdStatus = OrderStatus::get();
	   
	   $invoice_date = date('Y-m-d', strtotime($order_data->created_at));
	   
   //echo $pdf = view('emails.invoice', compact('order_data', 'OdStatus'))->render(); die;
   $pdf = PDF::loadView('emails.invoice', compact('order_data', 'OdStatus')); 
   //dd($pdf);
   //$pdf->save(public_path('uploads/learnhindituts_pdf.pdf'));
   
   return $pdf->download('Invoice_'.config('const.site_setting.name').'_Order_No # '.$id.' Date_'.$invoice_date.'.pdf');

	} 
}
