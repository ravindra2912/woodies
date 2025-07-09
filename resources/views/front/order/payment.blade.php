@extends('front.layouts.index')

@section('seo')
	

		<title>Bajarang | Payment</title>
	    
	
@endsection

@section('content')

	<section id="nevigation-header">
		<h3>Order Payment</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Cart <i class="fa-solid fa-angle-right"></i> CheckOut <i class="fa-solid fa-angle-right"></i>Order Payment</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container text-center">
		<input type="hidden" name="sitename" value="{{ config('const.site_setting.name') }}" />
		<input type="hidden" name="sitelogo" value="{{ config('const.site_setting.logo') }}" />
		<input type="hidden" name="KEY_ID" value="{{ config('const.rezorpayEnv') == 'live'? config('const.rezorpayLiveKey'):config('const.rezorpayTestKey') }}" />	
		<form id="myf" action="{{ route('order.order_payment') }}" method="post" enctype="multipart/form-data"> @csrf
				<input type="hidden" name="order" value="{{$order->id}}" />
				<input type="hidden" name="name" value="{{$order->name}}" />
				<input type="hidden" name="email" value="{{$order->user_data->email}}" />
				<input type="hidden" name="contacts" value="{{$order->contact}}" />
				<input type="hidden" name="amount" value="{{ number_format((float)$order->total, 2, '.', '')}}" />
				<input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id" value="" />
			</form>
			<p>Payment...</p>
			<button class="btn btn-success mr-3 rezorpay-btn">Payment</button>
			<a href="{{ url('/') }}" class="btn btn-danger">Cancel</a>
			
		</div>
	</section>
	
	
  
	

@endsection


@section('custom_js')
		<script src="{{ asset('front/js/rezorpay/jquery.min.js') }}"></script>
		<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

		<script src="{{ asset('front/js/rezorpay/rezorpay.js') }}"></script>
		
@endsection