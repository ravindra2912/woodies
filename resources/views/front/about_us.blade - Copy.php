@extends('front.layouts.index')

@section('seo')
	
	@php
			$description = 'Bajarang';
			$keywords = 'Bajarang';
		@endphp

		<title>Bajarang | About</title>
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

@section('custom_css')  
<link rel="stylesheet" type="text/css" href="https://dev.coreangle.in/yousmart/assets/admin/css/vendors/owlcarousel.css">

<style>
	.progressimg{
		height: 75px;
		width: 90px;
		object-fit: contain;
		margin-right: 15px;
	}
	
	.successimg{
		width: -webkit-fill-available;
		padding: 10px;
	}
	
	.analitis {
		margin-top: -130px;
		margin-top: -130px;
		display: flex;
		justify-content: center;
	}
	
	.analitis .row {
		border: 10px solid #B8B8B8;
	}
	
	.analitis .row .h1{
		font-size: 50px;
	}
	
	.analitis .row .mb-0{
		font-size: 15px;
		line-height: 1;
		margin-top: 10px;
	}
	
	.progress, .progress-bar {
		border-radius: 10px;
		height: 8px;
	}


/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++
			circle progress
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
.circle_progress {
  width: 80px;
  height: 80px !important;
  float: left; 
  line-height: 150px;
  background: none;
  margin: 20px;
  box-shadow: none;
  position: relative;
}
.circle_progress:after {
  content: "";
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 12px solid var(--secondary);	
  position: absolute;
  top: 0;
  left: 0;
}
.circle_progress>span {
  width: 50%;
  height: 100%;
  overflow: hidden;
  position: absolute;
  top: 0;
  z-index: 1;
}
.circle_progress .circle_progress-left {
  left: 0;
}
.circle_progress .circle_progress-bar {
  width: 100%;
  height: 100%;
  background: none;
  border-width: 12px;
  border-style: solid;
  position: absolute;
  top: 0;
}
.circle_progress .circle_progress-left .circle_progress-bar {
  left: 100%;
  border-top-right-radius: 80px;
  border-bottom-right-radius: 80px;
  border-left: 0;
  -webkit-transform-origin: center left;
  transform-origin: center left;
}
.circle_progress .circle_progress-right {
  right: 0;
}
.circle_progress .circle_progress-right .circle_progress-bar {
  left: -100%;
  border-top-left-radius: 80px;
  border-bottom-left-radius: 80px;
  border-right: 0;
  -webkit-transform-origin: center right;
  transform-origin: center right;
  animation: loading-1 1.8s linear forwards;
}
.circle_progress .circle_progress-value {
  width: 90%;
  height: 90%;
  border-radius: 50%;
  background: #fff;
  font-size: 24px;
  color: #000;
  line-height: 75px;
  text-align: center;
  position: absolute;
  top: 5%;
  left: 5%;
}
.circle_progress.blue .circle_progress-bar {
  border-color: var(--primary);
}
.circle_progress.blue .circle_progress-left .circle_progress-bar {
  animation: loading-2 1.5s linear forwards 1.8s;
}

@keyframes loading-1 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }
}
@keyframes loading-2 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(125deg);
    transform: rotate(125deg);
  }
}
@keyframes loading-3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(135deg);
    transform: rotate(135deg);
  }
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++
			image image
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
#container {
  perspective: 30px;
}

#inner {
  transition: transform 0.5s;
  -webkit-transition: transform 0.5s;
}









</style>

@endsection

@section('content')

	<section id="nevigation-header">
		<h3>About Bajarang</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> About Us</p>
	</section>







  
  <section id="about" class="mt-5 mb-5 pb-5">
		<div class="container" >
			<div class="row">
				<div class="col-lg-6 col-md-6 col-12">
					<div id="container">
					  <div id="inner">
							<img class="successimg" src="{{ asset('front/images/about/1.webp') }}" />
					  </div>
					  </div>
					
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<h5 class="text-primary">About us</h5>
					<h2 class="font-weight-bold">A World Leading & Popular Online Shopping Solution Provider.</h2>
					<div class=" mt-4 mb-4">

						<div class="circle_progress blue mt-0">
							<span class="circle_progress-left">
								<span class="circle_progress-bar"></span>
							</span>
							<span class="circle_progress-right">
								<span class="circle_progress-bar"></span>
							</span>
							<div class="circle_progress-value">75%</div>
						</div>


						<!-- img class="progressimg" src="{{ asset('front/images/about/2.png') }}" / -->
						<p class="progresstext font-weight-bold h4">Mation ullamco laboris nisi ut alior in rep rehend er fugiat nulla pariatur.</p>
					</div>
					<br>
					<p class="text-muted">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspicia tis unde omni od tempor incididunt ut labore.</p>
					
					<div class="row mt-5" id="service-info">
						<div class="col-lg-4 col-md-4 col-12 text-center mb-3">
							<div class="section-border p-2  service-box">
								<div class="service-icon mb-2">
									<img src="{{ asset('front/images/service/parcel.png') }}" alt="Easy Returns" />
								</div>
								<p class="font-weight-bold mb-0">Easy Returns</p>
								<p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-12 text-center mb-3">
							<div class="section-border p-2  service-box">
								<div class="service-icon mb-2">
									<img src="{{ asset('front/images/service/credit-card.png') }}" alt="Secure Payments" />
								</div>
								<p class="font-weight-bold mb-0">Secure Payments</p>
								<p class="service-info">Ut enim ad minim veniam liquip ami tomader</p>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-12 text-center align-self-center mb-3">
							<button class="btn btn-primary btn-sm btn-round px-4">READ MORE</button>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>
  
	<section id="OurSkills" class="bg-secondary pt-5 pb-5">
	
		<div class="analitis">
			<div class="w-75 p-5 btn-round row bg-white">
				<div class="text-primary col-lg-4 col-md-4 col-12 d-flex justify-content-center">
					<p class="h1 font-weight-bold pr-2 counter-count">120K</p>
					<p class="mb-0 align-self-center">Total<br>Products</p>
				</div>
				<div class="text-primary col-lg-4 col-md-4 col-12 d-flex justify-content-center">
					<p class="h1 font-weight-bold pr-2 counter-count">2K</p>
					<p class="mb-0 align-self-center">Worldwide<br>Customers</p>
				</div>
				<div class="text-primary col-lg-4 col-md-4 col-12 d-flex justify-content-center">
					<p class="h1 font-weight-bold pr-2 counter-count">120K</p>
					<p class="mb-0 align-self-center">Completed<br>Orders</p>
				</div>
				
			</div>
		</div>
	
		<div class="container mt-5">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-12 mb-5">
					<p class="h5 text-primary">Our Skills</p>
					<p class="h3 text-weight-bold mb-4">We provide solutions to engage customers</p>
					<p class="text-muted">Mation ullamco laboris nisi ut aliquip exea core dolor in reprehend erfu giat nulla pariatur. Ut enim minim veniam, quis nostrud exercitation ris uip ex ea commodo.</p>
				
					<button class="btn btn-primary btn-round btn-sm mt-4 px-3">Read mores</button>
				</div>
				
				<style>
					
				</style>
				
				<div class="col-lg-6 col-md-6 col-12">
					<div class="mb-4">
						<p  class="mb-1">Business Analysis <span class="float-right">70%</span></p>
						<div class="progress">
						  <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<div class="mb-4">
						<p  class="mb-1">Marketing Strategy <span class="float-right">90%</span></p>
						<div class="progress">
						  <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<div class="mb-4">
						<p class="mb-1">Final Chart <span class="float-right">60%</span></p>
						<div class="progress">
						  <div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	

	<style>
		.testy{
			    border-radius: 7px;
				box-shadow: 0px 0px 6px #6c757d;
		}
		
		.testy .dash span{
			background: var(--primary);
			padding: 5px 4px;
			border: 1px solid red;
			border-bottom-right-radius: 10px;
			margin-right:3px;
		}

		.testy .user-info img{
			height: 50px;
			width: 50px;
			object-fit: contain;
			border-radius: 100%;
		}
	</style>
	<section class="mt-5 mb-5 pb-5">
		<div class="container">
			<div class="row">
				<div class="col-md-5 p-4"> 
					<p class="h1 mb-4">What Customers Say About Us</p>
					<p class="text-muted">Bobore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitat ion ullamco laboris</p>
				</div>
				<div class="col-md-7 col-12 row"> 
					<div class="col-md-6 col-12 mb-3">
						<div class="testy p-4">
							<p class="dash">
								<span></span>
								<span></span>
							</p>
							<div class="ratting text-right">
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-muted"></i>
							</div>
							<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusncididunt ut labo re et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamc oaliquip ex ea commodo consequa uis aute irure dolor...</p>
							<div class="user-info row">
								<div class="col-md-2 col-3">
									<img src="{{ asset('uploads/default_images/default_image.png') }}" />
								</div>
								<div class="col-md-10 col-9">
									<p class="font-weight-bold mb-0">James Anderson</p>
									<p class="text-muted">Lorem ipsum</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-12 mb-3">
						<div class="testy p-4">
							<p class="dash">
								<span></span>
								<span></span>
							</p>
							<div class="ratting text-right">
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
								<i class="fa-solid fa-star text-warning"></i>
							</div>
							<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusncididunt ut labo re et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamc oaliquip ex ea commodo consequa uis aute irure dolor...</p>
							<div class="user-info row">
								<div class="col-md-2 col-3">
									<img src="{{ asset('uploads/default_images/default_image.png') }}" />
								</div>
								<div class="col-md-10 col-9">
									<p class="font-weight-bold mb-0">James Anderson</p>
									<p class="text-muted">Lorem ipsum</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</section>

	<script src="https://dev.coreangle.in/yousmart/assets/admin/js/owlcarousel/owl.carousel.js"></script>
@endsection

@section('custom_js') 
<script>
	$('.counter-count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
          
          //chnage count up speed here
            duration: 2000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now)+'K');
            }
        });
    });
</script>

<script>
	(function() {
  // Init
  var container = document.getElementById("container"),
      inner = document.getElementById("inner");

  // Mouse
  var mouse = {
    _x: 0,
    _y: 0,
    x: 0,
    y: 0,
    updatePosition: function(event) {
      var e = event || window.event;
      this.x = e.clientX - this._x;
      this.y = (e.clientY - this._y) * -1;
    },
    setOrigin: function(e) {
      this._x = e.offsetLeft + Math.floor(e.offsetWidth / 2);
      this._y = e.offsetTop + Math.floor(e.offsetHeight / 2);
    },
    show: function() {
      return "(" + this.x + ", " + this.y + ")";
    }
  };

  // Track the mouse position relative to the center of the container.
  mouse.setOrigin(container);

  //----------------------------------------------------

  var counter = 0;
  var refreshRate = 10;
  var isTimeToUpdate = function() {
    return counter++ % refreshRate === 0;
  };

  //----------------------------------------------------

  var onMouseEnterHandler = function(event) {
    update(event);
  };

  var onMouseLeaveHandler = function() {
    inner.style = "";
  };

  var onMouseMoveHandler = function(event) {
    if (isTimeToUpdate()) {
      update(event);
    }
  };

  //----------------------------------------------------

  var update = function(event) {
    mouse.updatePosition(event);
    updateTransformStyle(
      (mouse.y / inner.offsetHeight / 2).toFixed(2),
      (mouse.x / inner.offsetWidth / 2).toFixed(2)
    );
  };

  var updateTransformStyle = function(x, y) {
    var style = "rotateX(" + x + "deg) rotateY(" + y + "deg)";
    inner.style.transform = style;
    inner.style.webkitTransform = style;
    inner.style.mozTranform = style;
    inner.style.msTransform = style;
    inner.style.oTransform = style;
  };

  //--------------------------------------------------------

  container.onmousemove = onMouseMoveHandler;
  container.onmouseleave = onMouseLeaveHandler;
  container.onmouseenter = onMouseEnterHandler;
})();
</script>
@endsection
