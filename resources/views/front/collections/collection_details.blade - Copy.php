@extends('front.layouts.index')

@section('seo')
	
		@php
			$description = $Category->SEO_description;
			$keywords = $Category->SEO_tags ;
			$title = ucfirst($Category->name). ' Collection';
			$image = (file_exists($Category->small_image))?asset($Category->small_image):asset('front/images/logo.png');
		@endphp

		<title>{{ $title }}</title>
	    <meta name="description" content="{{ $description }}">
	    <meta property="image" content="{{ $image }}">
	    <meta property="image:width" content="300"/>
	    <meta property="image:height" content="300"/>
	    <meta name="keywords" content="{{ $keywords }}">
	    <meta name="author" content="Bajarang">
	    <meta name="distribution" content="global">
	    <meta name="DC.title" content="{{ $title }}">
	    <meta property="al:web:url" content="{{ url()->current() }}">
	    <meta name="copyright" content="Bajarang">
	    <meta property="og:title" content="{{ $title }}">
	    <meta property="og:description" content="{{ $description }}">
	    <meta property="og:url" content="{{ url()->current() }}">
	    <meta property="og:type" content="website" />
	    <meta property="og:site_name" content="Bajarang">
	    <meta property="og:image" content="{{ $image }}">
	    <meta property="og:image:width" content="300"/>
	    <meta property="og:image:height" content="300"/>
	    <meta property="twitter:card" content="summary">
	    <meta property="twitter:site" content="Bajarangdotcom">
	    <meta property="twitter:title" content="{{ $title }}">
	    <meta property="twitter:description" content="{{ $description }}">
	    <meta property="twitter:image" content="{{ $image }}">
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
		.sort-select{
			border: unset;
			font-size: 20px;
			font-weight: 900;
		}
		
	</style>	
@endsection

@section('content')

	<section id="nevigation-header">
		<h3>{{ strtoupper($Category->name) }} Collection</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Collection <i class="fa-solid fa-angle-right"></i> {{ strtoupper($Category->name) }} Collection</p>
	</section>
  
	<section id="collection" class="mt-5 mb-5 pb-5">
		<div class="container">
			<div class="row mb-5">
				<div class="col-lg-12 col-md-12 col-12">
					<div class="float-left">
						<p>Showing <b id="curent_list">1-{{ $productLists->total() }}</b> of <b id="records">{{ $productLists->total() }}</b> results</p>
					</div> 
					<div class="m-show float-right mb-3" >
						<button id="filter-btn" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#mobile-filter" aria-expanded="false" aria-controls="mobile-filter">Filters<span class="fa fa-filter pl-1"></span></button>
					</div>
					<div class="float-right">
						<span>Sort By 
							<select class="sort-select data-changes" id="sortby">
								<option value="0">Default Sorting</option>
								<option value="3" @if($request->sortby == 3) selected @endif>Sort By Popularity</option>
								<option value="4" @if($request->sortby == 4) selected @endif>Sort By Average Rating</option>
								<option value="5" @if($request->sortby == 5) selected @endif>Sort By Latest</option>
								<option value="2" @if($request->sortby == 2) selected @endif>Price High To Low</option>
								<option value="1" @if($request->sortby == 1) selected @endif>Price Low To High</option>
							</select>
						</span>
						<span><i class="fa-solid fa-list-ul pr-2 pl-3"></i> </span>
						<span><i class="fa-solid fa-border-all"></i> </span>
					</div>
				</div>
				
				@foreach($productLists as $val)
					<?php
						$product_img =  asset('uploads/default_images/default_image.png');
						$product_img2 =  '';
						if(isset($val->images_data) && count($val->images_data) > 0){
							if(file_exists($val->images_data[0]->small_image)){ $product_img = asset($val->images_data[0]->small_image);  }
							if(isset($val->images_data[1]) && !empty($val->images_data[1])){
								if(file_exists($val->images_data[1]->small_image)){ $product_img2 = asset($val->images_data[1]->small_image);  }
							}
						}
					?>
					<a href="{{ url('/products/'.$val->slug) }}" class="col-lg- col-md-3 col-12 mt-4 pos">
						<div class="new-product">
						  <div class="product-img">
								<img class="product__single" src="{{ $product_img }}" alt="{{ $val->name }}">
								@if($product_img2 != '') <img class="secondary-img" src="{{ $product_img2 }}" alt="{{ $val->name }}" > @endif
						  </div>
							<div class="product-info text-center">
								<!-- <div class="row mt-2 pb-0" >
									<div class="col-sm-12  col-12" >
										<div class="d-flex mt-2 justify-content-center">
											<p class="badges bg-danger"></p>
											<p class="badges bg-success"></p>
											<p class="badges bg-warning"></p>
										</div>
									</div>
								</div> -->
								<!-- <p class="product-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi feugiat velit urna, sed tincidunt est fermentum id.</p> -->
								<h4 class="product-name mt-3">{{ $val->name }}</h4>
								<div class="ratting">
									@for( $i=1; $i<=5; $i++)
										@if($val->rating >= $i)
											<i class="fa-solid fa-star text-warning"></i>
										@else
											<i class="fa-solid fa-star"></i>
										@endif
									@endfor
									<span>({{ $val->review_count }})</span>
								</div>
								<p class="product-price mt-2">Rs. {{ $val->price }}</p>
							</div>
						</div>
					</a>
				@endforeach
			</div>
			<div class="d-flax " >
				{{ $productLists->appends(request()->except('page'))->links() }}
              </div>
			
		</div>
	</section>
	
	
  
	

@endsection



