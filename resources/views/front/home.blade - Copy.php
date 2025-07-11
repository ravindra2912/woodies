@extends('front.layouts.index')

	@section('seo')
		
		@php
			$description = 'Bajarang';
			$keywords = 'Bajarang';
		@endphp

		<title>Bajarang | Home</title>
	    <meta name="description" content="{{ $description }}">
	    <meta property="image" content="{{ asset('front/images/logo.png') }}">
	    <meta property="image:width" content="300"/>
	    <meta property="image:height" content="300"/>
	    <meta name="keywords" content="{{ $keywords }}">
	    <meta name="author" content="Bajarang">
	    <meta name="distribution" content="global">
	    <meta name="DC.title" content="home">
	    <meta property="al:web:url" content="{{ url()->current() }}">
	    <meta name="copyright" content="Bajarang">
	    <meta property="og:title" content="home">
	    <meta property="og:description" content="{{ $description }}">
	    <meta property="og:url" content="{{ url()->current() }}">
	    <meta property="og:type" content="website" />
	    <meta property="og:site_name" content="Bajarang">
	    <meta property="og:image" content="{{ asset('front/images/logo.png') }}">
	    <meta property="og:image:width" content="300"/>
	    <meta property="og:image:height" content="300"/>
	    <meta property="twitter:card" content="summary">
	    <meta property="twitter:site" content="Bajarangdotcom">
	    <meta property="twitter:title" content="home">
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

@section('content')

	@if(isset($HomeBanner) && !empty($HomeBanner))
		<section id="home-slider">
			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
			  <div class="carousel-inner">
				@php $c = 1; @endphp
				@foreach($HomeBanner as $ban)
					<a href="{{ $ban->redirect_url }}" class="carousel-item {{ ($c == 1)?'active':'' }} ">
					  <img class="d-block w-100" src="{{ asset($ban->image) }}" alt="Banner">
					  <!-- div class="carousel-caption d-none d-md-block">
						<h5>Breezy Dresses </h5>
						<p>Up To 60% OFF.</p>
						<button type="button" class="btn btn-danger pr-4 pl-4" style="border-radius: 30px;">Explore Now</button>
					  </div -->
					</a>
					@php $c ++; @endphp
				@endforeach
			  </div>
			  <a class="carousel-control-prev action-btn" href="#carouselExampleControls" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"><i class="fa-solid fa-arrow-left"></i></span>
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next  action-btn" href="#carouselExampleControls" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"><i class="fa-solid fa-arrow-right-long"></i></span>
				<span class="sr-only">Next</span>
			  </a>
			</div>
		</section>
	@endif



  <section id="service-info">
      <div class="container mt-3">
        <div class="row">

            <div class="col-lg-3 col-md-3 col-12">
              <div class="row">
                <div class="col-lg-2 col-md-2 col-2 service-icon">
                   <img src="{{ asset('front/images/service/shipped.png') }}" alt="Free Shipping" />
                </div>
                <div class="col-lg-8 col-md-8  col-8">
                    <p class="heading">Free Shipping</p>
                    <p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
              <div class="row">
                <div class="col-lg-2 col-md-2 col-2 service-icon">
                <img src="{{ asset('front/images/service/credit-card.png') }}" alt="Secure Payments" />
                </div>
                <div class="col-lg-8 col-md-8  col-8">
                    <p class="heading">Secure Payments</p>
                    <p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
              <div class="row">
                <div class="col-lg-2 col-md-2 col-2 service-icon">
                <img src="{{ asset('front/images/service/parcel.png') }}" alt="Easy Returns" />
                </div>
                <div class="col-lg-8 col-md-8  col-8">
                    <p class="heading">Easy Returns</p>
                    <p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
              <div class="row">
                <div class="col-lg-2 col-md-2 col-2 service-icon">
                <img src="{{ asset('front/images/service/headphones.png') }}" alt="24/7 Support" />
                </div>
                <div class="col-lg-8 col-md-8  col-8">
                    <p class="heading">24/7 Support</p>
                    <p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
                </div>
              </div>
            </div>


        </div>
      </div>
  </section>

  <section id="latest-arival">
    <div class="container mt-5">
      <div class="row header-contaimer">
        <div class="col-lg-12 col-md-12 col-12">
          <h4>Latest Arrival</h4>
          <p>Showing our latest arrival on this summer</p>
        </div>

		@foreach($LatestArrival as $val)
			<?php
				$product_img =  asset('uploads/default_images/default_image.png');
				$product_img2 =  asset('uploads/default_images/default_image.png');
				if(isset($val->images_data) && count($val->images_data) > 0){
					if(file_exists($val->images_data[0]->small_image)){ $product_img2 = $product_img = asset($val->images_data[0]->small_image);  }
			
					if(isset($val->images_data[1]) && !empty($val->images_data[1])){
						if(file_exists($val->images_data[1]->small_image)){ $product_img2 = asset($val->images_data[1]->small_image);  }
					}
				}
			?>
			<a href="{{ url('/products/'.$val->slug) }}" class="col-lg-3 col-md-3 col-6 mt-4 pos">
				<div class="product">
				  <div class="product-img">
						<img class="product__single" src="{{ $product_img }}" alt="{{ $val->name }}">
						<img class="secondary-img" src="{{ $product_img2 }}" alt="{{ $val->name }}" >
					  <!-- span class="badge badge-pill badge-danger">Top</span -->
				  </div>
					<div class="product-info">
						<div class="ratting">
							@for( $i=1; $i<=5; $i++)
								@if($val->rating >= $i)
									<i class="fa-solid fa-star text-warning"></i>
								@else
									<i class="fa-solid fa-star"></i>
								@endif
							@endfor
							<span>{{ $val->review_count }} Reviews</span>
						</div>
						<h4>{{ $val->name }}</h4>
						<p>Rs. {{ $val->price }}</p>

						<div class="d-flex  float-left mt-2">
							<p class="badges bg-danger"></p>
							<p class="badges bg-success"></p>
							<p class="badges bg-warning"></p>
						
						</div>
						<div class="size float-right">
							<p>L</p>
							<p>M</p>
							<p>XL</p>
						</div>
					</div>
				</div>
			</a>
		@endforeach
      </div>
    </div>
  </section>

  <section id="offer-grid">
    <div class="container mt-5">
      <div class="row">

        <div class="col-lg-4 col-md-4 col-12">

            <div class="offer-grid-1">
              <div class="row">
                <div class="col-lg-7 col-md-7 col-7 pl-5">
                   <p class="off">Get 40% Off</p>
                   <p class="lable">Man’s Latest Collection</p>
                    <p class="tag"><i class="fa-solid fa-chevron-right"></i> SHOP NOW</p>
                 </div>
                 <div class="col-lg-5 col-md-5 col-5">
                   <img src="{{ asset('front/images/offers/g1/1.webp') }}" alt="Man’s Latest Collection" >
                 </div>
                </div>
            </div>

            <div class="offer-grid-2">
                  <div class="text-center">
                   <img src="{{ asset('front/images/offers/g2/1.webp') }}" alt="Exclusive Shoes Collection" >
                 </div>
                <div class="text-center pt-4 p-4">
                   <p class="off">New in 2023</p>
                   <p class="lable">Exclusive Shoes Collection</p>
                    <p class="tag"><i class="fa-solid fa-chevron-right"></i> SHOP NOW</p>
                 </div>
            </div>

         </div>

         <div class="col-lg-4 col-md-4 col-12">

              <div class="offer-grid-3">
                <div class="text-center pt-4 p-4">
                   <p class="off">Couple Fashion</p>
                   <p class="lable">Best Collection for Stylish Couple</p>
                    <p class="tag"><i class="fa-solid fa-chevron-right"></i> SHOP NOW</p>
                 </div>
                 <div class="text-center">
                   <img src="{{ asset('front/images/offers/g3.webp') }}" alt="Best Collection for Stylish Couple" >
                 </div>
             </div>

            <div class="offer-grid-4 p-1">
              <div class="row">
              <div class="col-lg-7 col-md-7 col-7 pl-5">
                   <p class="off">Get 40% Off</p>
                   <p class="lable">Ulina Trendy Sunglass</p>
                    <p class="tag"><i class="fa-solid fa-chevron-right"></i> SHOP NOW</p>
                 </div>
                 <div class="col-lg-5 col-md-5 col-5 " style="align-self: flex-end;">
                   <img src="{{ asset('front/images/offers/g4.webp') }}" alt="Ulina Trendy Sunglass" >
                 </div>
                </div>
              
            </div>
         </div>

         <div class="col-lg-4 col-md-4 col-12">

          <div class="offer-grid-1">
            <div class="row">
              <div class="col-lg-7 col-md-7 col-7 pl-5">
                <p class="off">Be Stylish</p>
                <p class="lable">Girl’s Latest Fashion</p>
                  <p class="tag"><i class="fa-solid fa-chevron-right"></i> SHOP NOW</p>
              </div>
              <div class="col-lg-5 col-md-5 col-5">
                <img src="{{ asset('front/images/offers/g5.webp') }}" alt="Girl’s Latest Fashion" >
              </div>
              </div>
          </div>

          <div class="offer-grid-2">
              
              <div class="text-center pt-4 p-4">
                <p class="off">New in 2023</p>
                <p class="lable">Discover New Bag Collection</p>
                  <p class="tag"><i class="fa-solid fa-chevron-right"></i> SHOP NOW</p>
              </div>
              <div class="text-center">
                <img src="{{ asset('front/images/offers/g6.webp') }}" alt="Discover New Bag Collection" >
              </div>
          </div>

          </div>
         
      </div>
    </div>
  </section>

	@if(isset($featured) && !empty($featured))
	<section id="featured-product">
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
          <img class="pimg" src="{{ asset( $featured->image ) }}" alt="{{ $featured->name }}" />
          <!--img class="pimg" src="{{ asset('front/images/FEATURPRODUCT/1.png') }}" / -->
        </div>
		<p class="product-counter" data-id="2" data-date="{{ date_format(date_create($featured->featured_date), 'm, d, Y H:i:s') }}"><p>
      </div>
    </div>
	</section>
	@endif
	

  <section id="Popular-Product">
    <div class="container mt-5">
      <div class="row header-contaimer">

        <div class="col-lg-12 col-md-12 col-12">
          <h4>Popular Product</h4>
          <p>Showing our latest product on this summer</p>
        </div>
       

		@foreach($PopularProduct as $val)
			<?php
				$product_img =  asset('uploads/default_images/default_image.png');
				$product_img2 =  asset('uploads/default_images/default_image.png');
				if(isset($val->images_data) && count($val->images_data) > 0){
					if(file_exists($val->images_data[0]->small_image)){ $product_img2 = $product_img = asset($val->images_data[0]->small_image);  }
			
					if(isset($val->images_data[1]) && !empty($val->images_data[1])){
						if(file_exists($val->images_data[1]->small_image)){ $product_img2 = asset($val->images_data[1]->small_image);  }
					}
				}
			?>
			<a href="{{ url('/products/'.$val->slug) }}" class="col-lg-3 col-md-3 col-6 mt-4 pos">
				<div class="product">
				  <div class="product-img">
						<img class="product__single" src="{{ $product_img }}" alt="{{ $val->name }}">
						<img class="secondary-img" src="{{ $product_img2 }}" alt="{{ $val->name }}">
					  <!-- span class="badge badge-pill badge-danger">Top</span -->
				  </div>
					<div class="product-info">
						<div class="ratting">
							@for( $i=1; $i<=5; $i++)
								@if($val->rating >= $i)
									<i class="fa-solid fa-star text-warning"></i>
								@else
									<i class="fa-solid fa-star"></i>
								@endif
							@endfor
							<span>{{ $val->review_count }} Reviews</span>
						</div>
						<h4>{{ $val->name }}</h4>
						<p>Rs. {{ $val->price }}</p>

						<div class="d-flex  float-left mt-2">
							<p class="badges bg-danger"></p>
							<p class="badges bg-success"></p>
							<p class="badges bg-warning"></p>
						
						</div>
						<div class="size float-right">
							<p>L</p>
							<p>M</p>
							<p>XL</p>
						</div>
					</div>
				</div>
			</a>

		@endforeach

      </div>
    </div>
  </section>

  <section id="Popular-Product">
    <div class="container mt-5">
      <div class="row">
       <div class="col-lg-6 col-md-6 col-12 mb-3">
          <img src="{{ asset('front/images/Frame 3214.webp') }}" alt="Banner" style="width: -webkit-fill-available; object-fit: contain; height: auto;" />
       </div>
       <div class="col-lg-6 col-md-6 col-12 mb-3">
          <img src="{{ asset('front/images/Frame 3215.webp') }}" alt="Banner" style="width: -webkit-fill-available; object-fit: contain; height: auto;" />
       </div>
      </div>
    </div>
  </section>

<!-- category -->
  <section id="Popular-Product">
    <div class="container mt-5">
      <div class="row header-contaimer">
        <div class="col-lg-12 col-md-12 col-12 mb-3">
          <h4>Shop By Category</h4>
          <p>Showing our latest catergory on this summer</p>
        </div>
        <div class="col-lg-3 col-md-3 col-6 mb-3">
          <img src="{{ asset('front/images/category/1.webp') }}" alt="Banner" style="width: -webkit-fill-available; object-fit: contain; height: auto;" />
       </div>
        <div class="col-lg-3 col-md-3 col-6 mb-3">
          <img src="{{ asset('front/images/category/2.webp') }}" alt="Banner" style="width: -webkit-fill-available; object-fit: contain; height: auto;" />
       </div>
        <div class="col-lg-3 col-md-3 col-6 mb-3">
          <img src="{{ asset('front/images/category/3.webp') }}" alt="Banner" style="width: -webkit-fill-available; object-fit: contain; height: auto;" />
       </div>
        <div class="col-lg-3 col-md-3 col-6 mb-3">
          <img src="{{ asset('front/images/category/4.webp') }}" alt="Banner" style="width: -webkit-fill-available; object-fit: contain; height: auto;" />
       </div>
      </div>
    </div>
  </section>

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



