@extends('front.layouts.index')

@section('seo')
	
		@php
			$description = 'Bajarang PaymentMethod Method';
			$keywords = 'PaymentMethod Method';
		@endphp

		<title>Bajarang | PaymentMethod Method</title>
	    <meta name="description" content="{{ $description }}">
	    <meta property="image" content="{{ asset('front/images/logo.png') }}">
	    <meta property="image:width" content="300"/>
	    <meta property="image:height" content="300"/>
	    <meta name="keywords" content="{{ $keywords }}">
	    <meta name="author" content="Bajarang">
	    <meta name="distribution" content="global">
	    <meta name="DC.title" content="PaymentMethod Method">
	    <meta property="al:web:url" content="{{ url()->current() }}">
	    <meta name="copyright" content="Bajarang">
	    <meta property="og:title" content="PaymentMethod Method">
	    <meta property="og:description" content="{{ $description }}">
	    <meta property="og:url" content="{{ url()->current() }}">
	    <meta property="og:type" content="website" />
	    <meta property="og:site_name" content="Bajarang">
	    <meta property="og:image" content="{{ asset('front/images/logo.png') }}">
	    <meta property="og:image:width" content="300"/>
	    <meta property="og:image:height" content="300"/>
	    <meta property="twitter:card" content="summary">
	    <meta property="twitter:site" content="Bajarangdotcom">
	    <meta property="twitter:title" content="PaymentMethod Method">
	    <meta property="twitter:description" content="{{ $description }}">
	    <meta property="twitter:image" content="{{ asset('front/images/logo.png') }}">
	    <meta property="twitter:url" content="{{ url()->current() }}">
	    <meta name="twitter:domain" content="Bajarang">
	    <!-- link rel="alternate" href="" -->
	    <meta itemprop="name" content="Bajarang">
	    <meta itemprop="description" content="{{ $description }}">
	    <meta name="robots" content="index, follow">
	    <link rel="canonical" href="{{ url()->current() }}" />
	
@endsection

@section('custom_css')
	<style>
		.iconimg{
			height: 300px;
			width: -webkit-fill-available;
			object-fit: contain;
			margin-bottom: 25px;
		}
	</style>
@endsection

@section('content')

	<section id="nevigation-header">
		<h3>PaymentMethod Method</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> PaymentMethod Method</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-12">
					<img class="iconimg" src="{{ asset('front/images/ShippingMethod/payment-method 1.png') }}" />
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<h4 class="font-weight-bold">Check / Money order</h4>
					<p class="h5 mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed imperdiet libero id nisi euismod, sed porta est consectetur deserunt.</p>
					<p class="mt-5">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				</div>
				<div class="col-lg-12 col-md-12 col-12 m-hide">
					<img class="iconimg" src="{{ asset('front/images/curved-arrow 1.png') }}" style="height: 200px;" />
				</div>
				
			</div>
			
			<div class="row flex-row-reverse">
				<div class="col-lg-6 col-md-6 col-12">
					<img class="iconimg" src="{{ asset('front/images/ShippingMethod/tracking 1.png') }}" />
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<h4 class="font-weight-bold">Saved Payment Methods</h4>
					<p class="h5 mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed imperdiet libero id nisi euismod, sed porta est consectetur deserunt.</p>
					<p class="mt-5">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				</div>
				<div class="col-lg-12 col-md-12 col-12 m-hide">
					<img class="iconimg" src="{{ asset('front/images/curved-arrow 2.png') }}" style="height: 200px;" />
				</div>
				
			</div>
			
			<div class="row">
				<div class="col-lg-6 col-md-6 col-12">
					<img class="iconimg" src="{{ asset('front/images/ShippingMethod/delivery 1.png') }}" />
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<h4 class="font-weight-bold">Cash on Delivery</h4>
					<p class="h5 mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed imperdiet libero id nisi euismod, sed porta est consectetur deserunt.</p>
					<p class="mt-5">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				</div>
				
			</div>
			
		</div>
	</section>
	
@endsection



