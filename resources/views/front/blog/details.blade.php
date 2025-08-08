@extends('front.layouts.index', ['seo' => [
'title' => 'home',
'description' => 'home',
'keywords' => 'home' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('content')
@php
	$HomeBanner = [];
@endphp
@if(isset($HomeBanner) && !empty($HomeBanner))
<section id="home-slider">
	<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			@php $c = 1; @endphp
			@foreach($HomeBanner as $ban)
			<div class="carousel-item {{ ($c == 1)?'active':'' }} ">
				<img @if($c==1) fetchpriority="high" @else loading="lazy" @endif class="d-block w-100" src="{{ getImage($ban->image) }}" alt="Banner">
				<!-- <div class="carousel-caption d-none d-md-block">
					<div class="div">
						<h5>Breezy Dresses </h5>
						<p>Up To 60% OFF.</p>
						<a href="{{ $ban->redirect_url }}" class="btn btn-danger pr-4 pl-4" style="border-radius: 30px;">Explore Now</a>
					</div>
				</div> -->
			</div>
			@php $c ++; @endphp
			@endforeach
		</div>
		<a class="carousel-control-prev action-btn" href="#carouselExampleControls" role="button" data-slide="prev">
			<span class="" aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next  action-btn" href="#carouselExampleControls" role="button" data-slide="next">
			<span class="" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</section>

@endif

<section class="p-0" id="blogdetails">
	<div class="row m-0 banner" style="background: {{ $blog->background_color }};">
		<div class="col-12 mt-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a title="Blog" href="{{ route('blogs') }}">Blog</a>
					</li>
					<li class="breadcrumb-item" aria-current="page">How to Convert PSD to WooCommerce? Easy Steps!</li>
				</ol>
			</nav>
		</div>
		<div class="col-md-6 col-12 blog-type">
			<ul class="blog-type-list mt-4">
				<li><a href="">E-Commerce</a>
				</li>
				<li><a href="">Shop</a>
				</li>
			</ul>
			<h1 class="text-white title mt-4">{{ $blog->title }}</h1>
			<p class="text-white">Created At : {{ get_date($blog->created_at, 'd M Y') }}</p>
		</div>
		<div class="col-md-6 col-12">
			<img src="{{ getImage($blog->image) }}" />
		</div>

	</div>
	<div class="container">
		{!! $blog->description !!}
	</div>
</section>






@endsection