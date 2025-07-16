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

@if(isset($HomeBanner) && !empty($HomeBanner))
<section id="home-slider">
	<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			@php $c = 1; @endphp
			@foreach($HomeBanner as $ban)
			<div class="carousel-item {{ ($c == 1)?'active':'' }} ">
				<img fetchpriority="high" class="d-block w-100" src="{{ getImage($ban->image) }}" alt="Banner">
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

<section id="home-category">
	<div class="container mt-3">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-12 mb-3 ">
				<h4 class="font-weight-bold">Category</h4>
			</div>
			@foreach ($categoty as $cat)
			<a href="{{ route('Products') }}?category={{ $cat->slug }}" class="col-lg-3 col-md-4 col-6 text-center ">
				<img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="rounded cat-img" />
				<label class="pt-1">{{ $cat->name }}</label>
			</a>
			@endforeach
		</div>
	</div>
</section>

<section id="latest-arival ">
	<div class="container  mt-5 pt-2">
		<div class="row header-contaimer ">
			<div class="col-lg-12 col-md-12 col-12 d-flex justify-content-between align-items-center">
				<h4 class="font-weight-bold">Latest Arrival</h4>
				<a class="" href="{{ route('Products') }}">View All <i class="fa-solid fa-arrow-right"></i></a>
			</div>

			@foreach($LatestArrival as $val)
			<a href="{{ url('/products/'.$val->slug) }}" class="col-md-3 col-6 mt-4 pos p-0">
				<div class="new-product">
					<div class="product-img">
						<img loading="lazy" class="product__single" src="{{ getImage(isset($val->images_data[0])?$val->images_data[0]->image:'') }}" alt="{{ $val->name }}">
						<img loading="lazy" class="secondary-img" src="{{ getImage(isset($val->images_data[1]) ? $val->images_data[1]->image:(isset($val->images_data[0])?$val->images_data[0]->image:'')) }}" alt="{{ $val->name }}">

					</div>
					<div class="product-info text-center">
						<h4 class="product-name mt-3">{{ $val->name }}</h4>
						<!-- <div class="ratting">
							@for( $i=1; $i<=5; $i++)
								@if($val->rating >= $i)
								<i class="fa-solid fa-star text-warning"></i>
								@else
								<i class="fa-solid fa-star"></i>
								@endif
								@endfor
								<span>({{ $val->review_count }})</span>
						</div> -->
						<p class="product-price mt-2 text-primary">Rs. {{ $val->price }} <del class="text-muted pl-2"  >Rs. {{ $val->original_price }}</del></p>
					</div>
				</div>
			</a>
			@endforeach
		</div>
	</div>
</section>

<!-- <section id="offer-grid">
	<div class="container mt-5">
		<div class="row">

			<div class="col-lg-4 col-md-4 col-12">
				<div class="offer-box">
					<img loading="lazy" src="{{ asset('front/images/offers/1.png') }}" title="Get 40% OFF" />
					<div class="offer-contant text-center">
						<div class="box">
							<p><b>Get 40% OFF</b></p>
							<p>Man’s Latest Collection</p>
							<a href="{{ url('/collections/clothings') }}" class="btn btn-primary btn-sm" alt="Shop Now"><i class="fa-solid fa-chevron-right pr-2"></i>Shop Now</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12">
				<div class="offer-box">
					<img loading="lazy" src="{{ asset('front/images/offers/2.png') }}" title="Couple Fashion" />
					<div class="offer-contant text-center">
						<div class="box">
							<p><b>Couple Fashion</b></p>
							<p>Best collection for Stylish Couple</p>
							<a href="{{ url('/collections/clothings') }}" class="btn btn-primary btn-sm" alt="Shop Now"><i class="fa-solid fa-chevron-right pr-2"></i>Shop Now</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12">
				<div class="offer-box">
					<img loading="lazy" class="py-4" src="{{ asset('front/images/offers/3.png') }}" title="Be stylish" />
					<div class="offer-contant text-center">
						<div class="box">
							<p><b>Be stylish</b></p>
							<p>Girl’s Latest Fashion</p>
							<a href="{{ url('/collections/clothings') }}" class="btn btn-primary btn-sm" alt="Shop Now"><i class="fa-solid fa-chevron-right pr-2"></i>Shop Now</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12">
				<div class="offer-box">
					<img loading="lazy" src="{{ asset('front/images/offers/4.png') }}" style="height: 260px; width: 55%;" title="Ncw in 2023" />
					<div class="offer-contant text-center">
						<div class="box">
							<p><b>Ncw in 2023</b></p>
							<p>Exclusive shoes Collection</p>
							<a href="{{ url('/collections/clothings') }}" class="btn btn-primary btn-sm" alt="Shop Now"><i class="fa-solid fa-chevron-right pr-2"></i>Shop Now</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12">
				<div class="offer-box">
					<img loading="lazy" src="{{ asset('front/images/offers/5.png') }}" style="height: 280px; width: 65%;" title="Get 40% off" />
					<div class="offer-contant text-center">
						<div class="box">
							<p><b>Get 40% off</b></p>
							<p>Ulina Trendy Sunglass</p>
							<a href="{{ url('/collections/clothings') }}" class="btn btn-primary btn-sm" alt="Shop Now"><i class="fa-solid fa-chevron-right pr-2"></i>Shop Now</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12">
				<div class="offer-box">
					<img loading="lazy" src="{{ asset('front/images/offers/6.png') }}" style="height: 260px; width: 45%;" title="Ncw in 2023" />
					<div class="offer-contant text-center">
						<div class="box">
							<p><b>Ncw in 2023</b></p>
							<p>Discover new bag collection</p>
							<a href="{{ url('/collections/clothings') }}" class="btn btn-primary btn-sm" alt="Shop Now"><i class="fa-solid fa-chevron-right pr-2"></i>Shop Now</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section> -->

@if(isset($featured) && !empty($featured))
<!-- section id="featured-product">
    <div class="container mt-5">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
          <p class="heading">Featured Product</p>
          <h4 class="p-name">{{ $featured->name }}</h4>
          <p class="p-info">{{ $featured->short_description }}</p>
        
          <div class="mb-2">
            <span class="selle-price">$199</span>
            <span class="price">${{ $featured->price }}</span>
            <a class="btn btn-primary" href="{{ url('/products/'.$featured->slug) }}" >Buy Now</a>
          </div>
          <p>End in</p>
          <div class="timer">
              <div class="text-center">
                <div class="til days" >00</div>
                <p>Days</p>
              </div>
              <div class="text-center">
                <div class="til hrs">00</div>
                <p>HRS</p>
              </div>
              <div class="text-center">
                <div class="til mins">00</div>
                <p>MINS</p>
              </div>
              <div class="text-center">
                <div class="til secs">00</div>
                <p>SECS</p>
              </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12 text-center">
          <img loading="lazy"  class="pimg" src="{{ asset( $featured->image ) }}" alt="{{ $featured->name }}" />
        </div>
		<p class="product-counter" data-id="2" data-date="{{ date_format(date_create($featured->featured_date), 'm, d, Y H:i:s') }}"><p>
      </div>
    </div>
	</section -->
@endif


<!-- <section id="Popular-Product">
	<div class="container  mt-5 section-border p-2 section-border">
		<div class="row header-contaimer ">
			<div class="col-lg-12 col-md-12 col-12 text-center">
				<h4 class="font-weight-bold">Popular product</h4>
				<p>Showing our latest arrival on this summer</p>
			</div>

			<div class="col-lg-12 col-md-12 col-12 mt-5">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					@php $c = 0; @endphp
					@foreach($PopularProduct as $val)
					<li class="nav-item">
						<a class="nav-link {{ ($c == 0)? 'active':'' }} " data-toggle="tab" href="#{{$val->slug }}" role="tab" aria-controls="{{$val->slug }}">
							<span class="texts">{{$val->name }}</span>
							<span class="m-hide"><i class="fab fa-pagelines"></i></span>
						</a>
					</li>
					@php $c++; @endphp
					@endforeach
				</ul>

				<div class="tab-content">
					@php $c = 0; @endphp
					@foreach($PopularProduct as $val)
					<div class="tab-pane {{ ($c == 0)? 'active':'' }}" id="{{$val->slug }}" role="tabpanel">
						<div>
							<div class="row px-2">
								<div class="col-lg-6 col-md-6 col-6 text-center p-0">
									<img loading="lazy" class="p-img" src="{{ getImage(isset($val->images_data[0]->image) ?$val->images_data[0]->image:'') }}" alt="{{ $val->name }}">
								</div>
								<div class="col-lg-6 col-md-6 col-6 text-center p-0">
									<img loading="lazy" class="p-img" src="{{ getImage(isset($val->images_data[1]->image) ?$val->images_data[1]->image:'') }}" alt="{{ $val->name }}">
								</div>
								<div class="col-lg-12 col-md-12 col-12 p-3">
									<p class="mt-2">{{$val->name }}</p>

									<div class="">
										<span class="pr-2">Rs. {{ $val->price }}</span>
										<span class="float-right">
											<a href="{{ url('/products/'.$val->slug) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-cart-shopping pr-2"></i>Shop Now</a>
										</span>
									</div>
								</div>
							</div>
						</div>

					</div>
					@php $c++; @endphp
					@endforeach
				</div>
			</div>
		</div>
	</div>
</section> -->

<section id="service-info" class="bg-light">
	<div class="container  py-5">
		<div class="row">

			<div class="col-lg-3 col-md-3 col-12 text-center ">
				<div class="section-border p-2 m-3 service-box">
					<div class="service-icon mb-2">
						<img loading="lazy" class="i1" src="{{ asset('front/images/service/shipped.png') }}" alt="Free Shipping" />
					</div>
					<p class="font-weight-bold mb-0">Free Shipping</p>
					<p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-12 text-center ">
				<div class="section-border p-2 m-3 service-box">
					<div class="service-icon mb-2">
						<img loading="lazy" class="i1" src="{{ asset('front/images/service/credit-card.png') }}" alt="Secure Payments" />
					</div>
					<p class="font-weight-bold mb-0">Secure Payments</p>
					<p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
				</div>
			</div>

			<div class="col-lg-3 col-md-3 col-12 text-center ">
				<div class="section-border p-2 m-3 service-box">
					<div class="service-icon mb-2">
						<img loading="lazy" class="i1" src="{{ asset('front/images/service/parcel.png') }}" alt="Easy Returns" />
					</div>
					<p class="font-weight-bold mb-0">Easy Returns</p>
					<p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
				</div>
			</div>

			<div class="col-lg-3 col-md-3 col-12 text-center ">
				<div class="section-border p-2 m-3 service-box">
					<div class="service-icon mb-2">
						<img loading="lazy" class="i1" src="{{ asset('front/images/service/headphones.png') }}" alt="24/7 Support" />
					</div>
					<p class="font-weight-bold mb-0">24/7 Support</p>
					<p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- <style>
	#trusted-content {
		.container {
			background: #f3f3f3;
			border-radius: 10px;
			padding: 20px 25px;
		}

		h2 {
			color: #333;
		}

		ul {
			list-style: none;
			padding: 0;
		}

		li {
			margin-bottom: 10px;
			padding-left: 25px;
			position: relative;
		}

		li::before {
			content: '✔';
			color: green;
			position: absolute;
			left: 0;
		}

		iframe {
			width: 100%;
			height: 315px;
			border: none;
			border-radius: 10px;
		}
	}
</style>
<section id="trusted-content">
	<div class="container">
		<div class="row ">
			<div class="col-md-6 col-12 mb-md-0 mb-3">
				<h2>Why Customers Trust Us</h2>
				<ul>
					<li>100% Satisfaction Guarantee</li>
					<li>Over 10,000+ Happy Customers</li>
					<li>100% Secure Payments</li>
					<li>24/7 Customer Support</li>
					<li>Trusted by Industry Experts</li>
				</ul>
			</div>
			<div class="col-md-6 col-12 video-container">
				<iframe width="560" height="315"
					src="https://www.youtube.com/embed/i4oTGptuJfE?si=4mnXqGbn9qrUvfSx"
					title="YouTube video player"
					frameborder="0"
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
					allowfullscreen>
				</iframe>
			</div>
		</div>
	</div>
</section> -->

<section id="about" class="mt-5 mb-5 pb-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12 col-md-12 col-12 text-center">
				<p class="h3 font-weight-bold">Frequently Asked Questions</p>
				<p>Mation ullamco laboris nisi ut aliquip exea core dolor in reprehender fugiat nulla pariatur.</p>
			</div>

			<div class="col-lg-8 col-md-8 col-12 mt-4">
				<div class="row " id="faqs">
					<div class="tab-content vertical w-100">
						<div class="tab-pane fade active show" id="panel21" role="tabpanel">
							<div class="accordion-section clearfix mt-0" aria-label="Question Accordions">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									@foreach (getFaqs() as $faq)
									<div class="panel panel-default">
										<div class="panel-heading p-3 mb-1" role="tab" id="heading{{ $faq->id }}">
											<div class="panel-title">
												<a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}" aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
													{{ $faq->question }}
												</a>
											</div>
										</div>
										<div id="collapse{{ $faq->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $faq->id }}">
											<div class="panel-body px-3 mb-4">
												<p>{{ $faq->answer }}</p>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
						<!-- Panel 1 -->
					</div>
				</div>

			</div>


		</div>

	</div>
</section>



<style>
	#offer-banner .overlay {
		position: absolute;
		height: 100%;
		width: 100%;
		background: rgba(0, 0, 0, 0.2);
		border-radius: 10px;
	}

	#offer-banner .carousel-caption {
		top: 8%;
		left: 9%;
		width: 28%;
		right: unset;
	}

	#offer-banner .carousel-caption h1 {
		font-family: 'Scheherazade New';
		font-style: normal;
		font-weight: 700;
		font-size: 58px;
		line-height: 72px;
		text-transform: capitalize;
		color: #FFFFFF;
	}

	#offer-banner .carousel-caption p {
		font-style: normal;
		font-weight: 800;
		font-size: 53px;
		line-height: 74px;
		text-align: center;
		text-transform: capitalize;
		color: #FFFFFF;
	}

	#offer-banner .carousel-indicators li {
		background-clip: unset;
		border-radius: 30px;
		width: 20px;
		height: 20px;
		border: 3px solid white;
	}

	#offer-banner .carousel-indicators .active {
		background: var(--primary);
	}

	@media only screen and (max-width: 600px) {
		#offer-banner .carousel-indicators li {
			width: 10px;
			height: 10px;
			border: 1px solid white;
		}
	}
</style>

<!-- <section id="offer-banner">
	<div class="container mt-5">
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			</ol>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<div class="d-block w-100">
						<div class="overlay"></div>
						<img loading="lazy" class="d-block w-100" src="{{ asset('front/images/slider/1.png') }}" alt="Banner">
					</div>

					<div class="carousel-caption d-none d-md-block">
						<h1>Get 40% OFF</h1>
						<p>Women’s New Collection</p>
						<button type="button" class="btn btn-danger pr-4 pl-4 mt-3" style="border-radius: 5px;"><i class="fa-solid fa-chevron-right pr-2"></i> Explore Now</button>
					</div>
				</div>
				<div class="carousel-item ">
					<div class="d-block w-100">
						<div class="overlay"></div>
						<img loading="lazy" class="d-block w-100" src="{{ asset('front/images/slider/1.png') }}" alt="Banner">
					</div>
					<div class="carousel-caption d-none d-md-block">
						<h1>Get 40% OFF</h1>
						<p>Women’s New Collection</p>
						<button type="button" class="btn btn-danger pr-4 pl-4 mt-3" style="border-radius: 5px;"><i class="fa-solid fa-chevron-right pr-2"></i> Explore Now</button>
					</div>
				</div>


			</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>


	</div>
</section> -->

<!-- category -->
<!-- @if(isset($categoty) && !empty($categoty))
<section id="">
	<div class="container section-border pt-5 pb-4 mt-5">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-12 text-center mb-4">
				<h4 class="font-weight-bold">Shop By Category</h4>
				<p>Showing our latest arrival on this summer</p>
			</div>

			@foreach ($categoty as $cat)
			<div class="col-lg-3 col-md-3 col-6 mb-3">
				<img loading="lazy" src="{{ $cat->banner_image_url }}" alt="category" style="width: -webkit-fill-available; object-fit: contain; height: auto; border-radius: 20px;" />
			</div>
			@endforeach
		</div>
	</div>
</section>
@endif -->

@endsection

@section('custom_js')

<script>
	var date = new Date("1, 8, 2023 00:00:00").getTime();

	const classExists = document.getElementsByClassName('product-counter');
	//console.log(classExists);
	//counter(date);
	if (classExists) {
		var date = $(classExists).data('date');
		//console.log(date);

		// Set the date we're counting down to
		var countDownDate = new Date(date).getTime();

		// Update the count down every 1 second
		var x = setInterval(function() {

			// Get today's date and time
			var now = new Date().getTime();

			// Find the distance between now and the count down date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			$('.days').html(("0" + days).slice(-2));
			$('.hrs').html(("0" + hours).slice(-2));
			$('.mins').html(("0" + minutes).slice(-2));
			$('.secs').html(("0" + seconds).slice(-2));

			// Display the result in the element with id="demo"
			//  document.getElementById("demo").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

			// If the count down is finished, write some text
			if (distance < 0) {
				clearInterval(x);
				$('.days').html('00');
				$('.hrs').html('00');
				$('.mins').html('00');
				$('.secs').html('00');
			}
		}, 1000);
	}
</script>

@endsection