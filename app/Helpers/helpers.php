<?php

use Carbon\Carbon;
use App\Models\Faq;
use App\Models\Coupon;
use App\Models\Orders;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\AddToCart;
use App\Models\LegalPage;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use App\Models\ProductImages;
use App\Models\ProductVariants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


//use Mail;
//use Auth;

function systemDetails()
{
	$system['name'] = 'localcoins';
	$system['version'] = '2.0';
	$system['build_version'] = '4.2.9';
	return $system;
}

function get_count()
{
	$data['cart_count'] = 0;
	$data['wishlist_count'] = 0;
	if (Auth::check()) {
		$data['cart_count'] = AddToCart::where('user_id', Auth::user()->id)->count();
		$data['wishlist_count'] = Wishlist::where('user_id', Auth::user()->id)->count();
	}

	return $data;
}

//check the cart if cart item outof Stock And reqired qty Lessthen item qyt then cart is update it's self
function check_cart()
{
	$data['changes'] = false;
	$carts = AddToCart::where('user_id', Auth::user()->id)
		->with(['product_data', 'images_data'])
		->get();

	foreach ($carts as $cdata) {
		$delete = false;
		$update = false;
		$qty = 0;
		if ($cdata->Variants_id != '') {
			$chack_variant = ProductVariants::find($cdata->Variants_id);
			if ($chack_variant) {
				if ($chack_variant->qty <= 0) {
					$delete = true;
				} else if ($cdata->quantity > $chack_variant->qty) {
					$qty = $chack_variant->qty;
					$update = true;
				}
			} else {
				if ($chack_variant->quantity <= 0) {
					$delete = true;
				} else if ($cdata->quantity > $cdata->product_data->quantity) {
					$qty = $chack_variant->qty;
					$update = true;
				}
			}
		} else {
			if ($cdata->product_data->quantity <= 0) {
				$delete = true;
			} else if ($cdata->quantity > $cdata->product_data->quantity) {
				$qty = $chack_variant->qty;
				$update = true;
			}
		}

		if ($delete) {
			AddToCart::where('user_id', Auth::user()->id)->where('id', $cdata->id)->delete();
			$data['changes'] = true;
		} else if ($update) {
			$carts = AddToCart::where('user_id', Auth::user()->id)->where('id', $cdata->id)->first();
			$carts->quantity = $qty;
			$carts->save();
			$data['changes'] = true;
		}
	}

	return $data;
}


function check_coupon($coupon_code, $user_id)
{
	$data['status'] = false;
	$data['msg'] = 'Coupon not exist';
	$data['discount'] = 0;
	$data['free_delivery'] = false;
	$amount = 0;
	$date = date('Y-m-d');
	$coupon = Coupon::where('coupon_code', $coupon_code)
		->whereDate('active_date', '<=', $date)
		->whereDate('end_date', '>=', $date)
		->where('status', 'Active')
		->first();

	//die;
	if ($coupon) {
		$data['coupon_id'] = $coupon->id;
		$add_to_cart = AddToCart::where('user_id', $user_id)
			->with(['product_data'])
			->get();

		foreach ($add_to_cart as $cart) {
			if (isset($cart->product_data) && $cart->product_data->coupon_id == $coupon->id) {
				if ($cart->Variants_id != null) {
					$ProductVariants = ProductVariants::find($cart->Variants_id);
					if ($ProductVariants) {
						$amount += $ProductVariants->amount * $cart->quantity;
					} else {
						$amount += $cart->product_data->price * $cart->quantity;
					}
				} else {
					$amount += $cart->product_data->price * $cart->quantity;
				}
			}
		}

		if ($amount > 0) {
			if ($coupon->coupon_type == 1) { // percentage
				$data['discount'] = ($amount * $coupon->coupon_percent) / 100;
			} else if ($coupon->coupon_type == 2) { // amount
				if ($amount >=  $coupon->coupon_amount) {
					$data['discount'] = $coupon->coupon_amount;
				} else {
					$data['discount'] = $amount;
				}
			} else  if ($coupon->coupon_type == 3) { // free shiping
				$data['free_delivery'] = true;
			}
			$data['status'] = true;
			$msg = 'Coupon Apply successFully';
			$data['msg'] = $msg;
		}
	}
	return $data;
}

function slug($string)
{
	return Illuminate\Support\Str::slug($string);
}


function cryptoQR($wallet)
{
	return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8";
}


// ************ image function start ***************

function fileRemoveStorage($imageObject)
{
	$storage = Storage::disk('local');
	if (!empty($imageObject) && $storage->exists("public/" . $imageObject)) {
		return $storage->delete("public/" . $imageObject);
	}
}

function fileUploadStorage($imageObject, $directory = "", $width = "", $hieght = "")
{
	if (!empty($imageObject)) {
		$imageName = $directory . "/" . time() . "_" . rand(11111, 99999) . '.' . $imageObject->getClientOriginalExtension();
		if ($width != "" && $hieght != "") {
			$dir = 'storage/' . $directory;
			if (!File::exists($dir)) {
				File::makeDirectory(public_path() . '/' . $dir, 0777, true);
			}

			$destinationPath = public_path('/storage/' . $imageName);
			$img = Image::make($imageObject->path());
			$img->resize($width, $hieght, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath);
		} else {
			$storage = Storage::disk('local');
			$uploaded = $storage->put('public/' . $imageName, file_get_contents($imageObject), 'public');
		}
		return $imageName;
	}
	return "";
}


function getImage($url = "")
{
	// dd(asset("storage/" . $url));

	$image = "storage/" . $url;
	if (!empty($url)) {
		// dd(public_path($image));
		if (file_exists(public_path($image))) {
			return asset("storage/" . $url);
		}
	}
	// return asset('admin/images/default.png');
	// $image = "storage/" . $url;
	// if (!empty($url)) {
	//     if (file_exists(public_path($image))) {
	//         return asset("storage/" . $url);
	//     }
	// }
	return config('const.site_setting.default_img');
}
// ************ image function end ***************

// function getImage($image)
// {
//     if (file_exists($image) && is_file($image)) {
//         return asset($image);
//     }

//     return asset('uploads/default_images/default_image.png');
// }

function get_datetime($date, $format = 'd-m-Y h:i A')
{
	return Carbon::parse($date)->translatedFormat($format);
}

function get_date($date, $format = 'd-m-Y')
{
	return Carbon::parse($date)->translatedFormat($format);
}

function get_time($date, $format = 'h:i A')
{
	return Carbon::parse($date)->translatedFormat($format);
}

function sent_order_email($id)
{

	$order = Orders::where('id', $id)
		->with(['order_items_data', 'order_logs_status', 'order_status', 'user_data'])
		->first();

	foreach ($order->order_items_data as $pdata) {
		$pdata->image  = asset('uploads/default_images/default_image.png');
		$pi = ProductImages::where('product_id', $pdata->product_id)->orderBy('id', 'asc')->first();
		if (isset($pi) && !empty($pi)) {
			if (file_exists($pi->thumbnail_image)) {
				$pdata->image = asset($pi->thumbnail_image);
			}
		}
	}

	if (isset($order) && !empty($order) && isset($order->order_status) && !empty($order->order_status) && $order->order_status->is_send == 1) {
		$SubscriptionUrl = 'SubscriptionUrl';
		//$html = view('emails.OrderEmail', compact('order' 'SubscriptionUrl'))->render();
		//echo($html);
		//die;

		if (isset($order->user_data) && !empty($order->user_data) && !empty($order->user_data->email)) {
			$info['subject'] = 'Order Confirmation';
			if (isset($order->order_status) && !empty($order->order_status)) {
				$info['subject'] = $order->order_status->email_subject;
			}
			//$info['to'] = $order->user_data->email;
			$info['to'] = 'goswamirvi@gmail.com';

			try {
				Mail::send('emails.OrderEmail', compact('order', 'SubscriptionUrl'), function ($message) use ($info) {
					$message->to($info['to']);
					$message->subject($info['subject']);
				});
			} catch (\Exception $e) {
				//$e->getMessage();
				return false;
			}
		}
	}
	return true;
}

function showMobileNumber($number)
{
	$length = strlen($number);
	return substr_replace($number, '***', 2, $length - 4);
}

function showEmailAddress($email)
{
	$endPosition = strpos($email, '@') - 1;
	return substr_replace($email, '***', 1, $endPosition);
}

function getRealIP()
{
	$ip = $_SERVER["REMOTE_ADDR"];
	//Deep detect ip
	if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
		$ip = $_SERVER['HTTP_FORWARDED'];
	}
	if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
		$ip = $_SERVER['HTTP_FORWARDED_FOR'];
	}
	if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
		$ip = $_SERVER['HTTP_X_REAL_IP'];
	}
	if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
		$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
	}
	if ($ip == '::1') {
		$ip = '127.0.0.1';
	}

	return $ip;
}

function getMainCategories()
{
	return Cache::rememberForever('main_categories_all', function () {
		return Category::where('status','Active')->where('parent_id', null)->take(8)->get();
	});
}

function getFaqs()
{
	return Cache::rememberForever('faqs_all', function () {
		return Faq::get();
	});
}

function getLagelage($pagetype)
{
	return LegalPage::where('page_type', $pagetype)->first()->description;
}

function getLagelages()
{
	return LegalPage::select('page_type')->where('status', 'active')->get();
}

function formatString($string)
{
	// Add space before capital letters
	$string = preg_replace('/([a-z])([A-Z])/', '$1 $2', $string);

	// Capitalize only the first letter
	return ucfirst(strtolower($string));
}

function getUserId()
{
	if (Auth::check()) {
		return Auth::user()->id;
	} else if (Auth::guard('api')->check()) {
		return Auth::guard('api')->user()->id;
	}
	return null;
}


// ============================
//  for suret project
//  ===============================

function Department_Sales()
{


	$invoice_date = Carbon::now()->format('d M Y');
	$departments = [
		[
			'name' => "POWERTOOLS",
			'data' => [
				[
					'Code' => "STL0012",
					'Description' => "hello",
					'Quantity' => 0,
					'Cost' => 0,
					'VAT' => 0,
					'Sales' => 0,
					'Profit' => 2,
				],
				[
					'Code' => "STL0012",
					'Description' => "hello",
					'Quantity' => 0,
					'Cost' => 0,
					'VAT' => 0,
					'Sales' => 0,
					'Profit' => 5,
				]
			]

		],
		[
			'name' => "ACCESSORY",
			'data' => [
				[
					'Code' => "PBORD001",
					'Description' => "hello",
					'Quantity' => 0,
					'Cost' => 0,
					'VAT' => 0,
					'Sales' => 0,
					'Profit' => 0,
				]
			]

		]

	];

	echo $pdf = view('surat.DepartmentsalesReport', compact('invoice_date', 'departments'))->render();
	die;
	$pdf = PDF::loadView('surat.DepartmentsalesReport', compact('invoice_date', 'departments'));
	//dd($pdf);
	//$pdf->save(public_path('uploads/learnhindituts_pdf.pdf')); 

	return $pdf->download('Department Sales Report ' . $invoice_date . '.pdf');
}

function Overdue_GRVs()
{
	$invoice_date = Carbon::now()->format('d M Y');
	$record = [
		[
			'GRVNo' => 123,
			'InvoiceNo' => '09/08/24',
			'Supplier' => 'Antheneon Engineering LTD',
			'GRVDate' => '09 Aug 2024 at 16:37 hrs',
			'DueDate' => '09 Aug 2024 at 16:37 hrs',
			'Total' => 5
		],
		[
			'GRVNo' => 123,
			'InvoiceNo' => '09/08/24',
			'Supplier' => 'Antheneon Engineering LTD',
			'GRVDate' => '09 Aug 2024 at 16:37 hrs',
			'DueDate' => '09 Aug 2024 at 16:37 hrs',
			'Total' => 3
		],
	];

	echo $pdf = view('surat.Overdue_GRVsReport', compact('invoice_date', 'record'))->render();
	die;
	$pdf = PDF::loadView('surat.Overdue_GRVsReport', compact('invoice_date', 'record'));
	//dd($pdf);
	//$pdf->save(public_path('uploads/learnhindituts_pdf.pdf')); 

	return $pdf->download('Overdue GRVs Report ' . $invoice_date . '.pdf');
}

function BusinessOverview()
{
	$invoice_date = Carbon::now()->format('d M Y');
	$record = [
		'Stock Values' => [
			'Opening Stock Value' => 'K35,771.82',
			'Current Stock Value' => 'K35,678.16',
		],
		'Stock Sold' => [
			'Quantity Sold' => '164.000',
			'Cost' => 'K108.65',
			'Sales Value' => 'K4,457.00',
			'Profit' => 'K4,348.35',
		],
		'Stock Received' => [
			'Items' => '0 Items Received',
			'Total Quantity Received' => '0.000',
			'Cost' => 'K0.00'
		],
		'Stock Adjusted' => [
			'Stock Adjustments' => '0 Adjustments Done',
			'Quantity' => '0.000',
			'Value' => 'K0.00'
		],
	];

	echo $pdf = view('surat.BusinessOverviewReport', compact('invoice_date', 'record'))->render();
	die;
	$pdf = PDF::loadView('surat.BusinessOverviewReport', compact('invoice_date', 'record'));
	//dd($pdf);
	//$pdf->save(public_path('uploads/learnhindituts_pdf.pdf')); 

	return $pdf->download('Business Overview Report ' . $invoice_date . '.pdf');
}

function SalesSummary()
{
	$invoice_date = Carbon::now()->format('d M Y');
	$record = [
		'PaymentTypeBreakdown' => [
			[
				'SLNo' => 1,
				'PaymentType' => 'Cash',
				'CostofSales' => 2000.00,
				'Total' => 2500.00,
				'profit' => 2500.00,
			]
		],
		'Top3SellersbyTurnover' => [
			[
				'StockCode' => 'DOR002',
				'Description' => '825 Flush Doors',
				'Quantity' => 20.00,
				'Total' => 250.00,
			]
		],
		'Top3SellersbyQty' => [
			[
				'StockCode' => 'DOR002',
				'Description' => '825 Flush Doors',
				'Quantity' => 20.00,
				'Total' => 250.00,
			]
		],
		'Top3DepartmentSales' => [
			[
				'SLNo' => '1',
				'Department' => 'DOORS / WINDOWS',
				'Total' => 250.00,
			]
		],
		'Top3CashierSales' => [
			[
				'SLNo' => '1',
				'Cashier' => 'Nthandose',
				'Total' => 250.00,
			]
		],
		'Top3ComputerSales' => [
			[
				'SLNo' => '1',
				'PCName' => 'Nthandose',
				'Total' => 250.00,
			]
		],
	];

	echo $pdf = view('surat.SalesSummaryReport', compact('invoice_date', 'record'))->render();
	die;
	$pdf = PDF::loadView('surat.SalesSummaryReport', compact('invoice_date', 'record'));
	//dd($pdf);
	//$pdf->save(public_path('uploads/learnhindituts_pdf.pdf')); 

	return $pdf->download('Sales Summary Report ' . $invoice_date . '.pdf');
}
