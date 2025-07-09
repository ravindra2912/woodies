@extends('front.layouts.index')

@section('seo')
	

		<title>Bajarang | Payment Responce</title>
	    
	
@endsection
@section('custom_js')
<style>
	.iconimg{
		height: 250px;
		width: -webkit-fill-available;
		object-fit: contain;
	}
</style>
@endsection
@section('content')

	<section id="nevigation-header">
		<h3>Payment Responce</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Cart <i class="fa-solid fa-angle-right"></i> CheckOut <i class="fa-solid fa-angle-right"></i>Payment Responce</p>
	</section>
  
  <section class="mt-5 mb-5 pb-5">
		<div class="container text-center">
			@if($order->payment_status == 1)
				<img class="iconimg" src="{{ asset('front/images/success.png') }}" />
				<p class="text-success h4 mt-4">Your Payment is Successful</p>
				<p>Thank you for your payment. An automated payment receipt will be sent to your registered email.</p>
				<a href="{{ url('/pdf_invoice/'.$order->id) }}" class="btn btn-primary btn-round pr-3 pl-3 mr-2">Invoice</a>
			@elseif($order->payment_type == 2)
				<img class="iconimg" src="{{ asset('front/images/success.png') }}" />
				<p class="text-success h4 mt-4">Your Order Place is Successful</p>
				<p>Thank you for your Order.</p>
				<a href="{{ url('/pdf_invoice/'.$order->id) }}" class="btn btn-primary btn-round pr-3 pl-3 mr-2">Invoice</a>
			@else
				<img class="iconimg" src="{{ asset('front/images/fail.png') }}" />
				<p class="text-danger h4 mt-4">Unfortunately payment was rejected</p>
				<p>Page while be automatically redirected to the main page or click button below.</p>
			@endif
			<a href="{{ url('/') }}" class="btn btn-primary btn-round pr-3 pl-3">Go To Home</a>
		</div>
	</section>
	
	
  
	

@endsection


@section('custom_js')
	
		
@endsection