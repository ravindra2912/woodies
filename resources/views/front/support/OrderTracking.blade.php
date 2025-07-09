@extends('front.layouts.index')

@section('seo')
	
		@php
			$description = 'Bajarang Order Tracking';
			$keywords = 'Order Tracking';
		@endphp

		<title>Bajarang | Order Tracking</title>
	    <meta name="description" content="{{ $description }}">
	    <meta property="image" content="{{ asset('front/images/logo.png') }}">
	    <meta property="image:width" content="300"/>
	    <meta property="image:height" content="300"/>
	    <meta name="keywords" content="{{ $keywords }}">
	    <meta name="author" content="Bajarang">
	    <meta name="distribution" content="global">
	    <meta name="DC.title" content="Order Tracking">
	    <meta property="al:web:url" content="{{ url()->current() }}">
	    <meta name="copyright" content="Bajarang">
	    <meta property="og:title" content="Order Tracking">
	    <meta property="og:description" content="{{ $description }}">
	    <meta property="og:url" content="{{ url()->current() }}">
	    <meta property="og:type" content="website" />
	    <meta property="og:site_name" content="Bajarang">
	    <meta property="og:image" content="{{ asset('front/images/logo.png') }}">
	    <meta property="og:image:width" content="300"/>
	    <meta property="og:image:height" content="300"/>
	    <meta property="twitter:card" content="summary">
	    <meta property="twitter:site" content="Bajarangdotcom">
	    <meta property="twitter:title" content="Order Tracking">
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
			height: 100px;
			width: -webkit-fill-available;
			object-fit: contain;
			margin-bottom: 25px;
		}
	</style>
@endsection

@section('content')

	<section id="nevigation-header">
		<h3>Order Tracking</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Order Tracking</p>
	</section>
  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-12 text-center">
					<p class="h5">To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
				</div>
				
				<div class="col-lg-6 col-md-6 col-12  mt-3">
					<label><b>Order ID</b></label>
					<input type="text" class="form-control" placeholder="Found in your order confirmation email." />
				</div>
				
				<div class="col-lg-6 col-md-6 col-12  mt-3">
					<label><b>Billing email</b></label>
					<input type="text" class="form-control" placeholder="Email you used during checkout." />
				</div>
				<div class="col-lg-12 col-md-12 col-12 text-center mt-3">
					<button class="btn btn-primary btn-round pr-3 pl-3">Track</button>
				</div>
			</div>
			
		</div>
	</section>
	
	<section  class="mt-5 mb-5 pb-5 pt-5 bg-secondary">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-12">
					<div class="card">
						<div class="card-body text-center">
							<img class="iconimg" src="{{ asset('front/images/OrderTraking/customerserviceagent.png') }}" />
							<p class="text-primary font-weight-bold">Step 1</p>
							<p class="h4 font-weight-bold mb-3">Title Tracking</p>
							<p>Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-4 col-12">
					<div class="card">
						<div class="card-body text-center">
							<img class="iconimg" src="{{ asset('front/images/OrderTraking/home-address 1.png') }}" />
							<p class="text-primary font-weight-bold">Step 2</p>
							<p class="h4 font-weight-bold mb-3">Title Tracking</p>
							<p>Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-4 col-12">
					<div class="card">
						<div class="card-body text-center">
							<img class="iconimg" src="{{ asset('front/images/OrderTraking/task-list 1.png') }}" />
							<p class="text-primary font-weight-bold">Step 3</p>
							<p class="h4 font-weight-bold mb-3">Title Tracking</p>
							<p>Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section id="about" class="mt-5 mb-5 pb-5">
		<div class="container text-center">
			<p class="h3 font-weight-bold mb-4">Get answers to all your questions you might have.</p>
			<p class="h5 mb-4">We will answer any questions you may have aboutour online sales right here.</p>
			<p>Monday to Friday from 09:00 to 21:00 UTC +0</p>
			<button class="btn btn-primary btn-round pr-3 pl-3 mt-2">Contact Now</button>
			
		</div>
	</section>
	
@endsection



