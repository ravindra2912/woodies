<!doctype html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="{{ config('const.site_setting.fevicon') }}" rel="icon">

	<title>{{ isset($seo['title']) ? $seo['title'].' | ':'' }} {{ config('const.site_setting.name') }}</title>

	@if (isset($seo) && !empty($seo))
	<meta name="description" content="<?= $seo['description'] ?>">
	<meta name="keywords" content="<?= $seo['keywords'] ?>">


	<link rel="canonical" href="{{ url()->current() }}" />

	<meta name="distribution" content="global">
	<meta http-equiv="content-language" content="en-gb">
	<meta name="city" content="<?= $seo['city'] ?>">
	<meta name="state" content="<?= $seo['state'] ?>">
	<meta name="geo.region" content="IN-GJ">
	<meta name="geo.placename" content="<?= $seo['city'] ?>">
	<meta name="DC.title" content="<?= $seo['title'] ?>">
	<meta name="geo.position" content="<?= $seo['position'] ?>">

	<!-- meta property="og:see_also" content="alternate url" -->

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta property="al:web:url" content="{{ url()->current() }}">

	<meta name="copyright" content="woodieo">

	<meta property="og:title" content="<?= $seo['title'] ?>">
	<meta property="og:description" content="<?= $seo['description'] ?>">
	<meta property="og:url" content="{{ url()->current() }}">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="woodieo - eccomerce Business">
	<meta property="og:locale" content="en_GB">
	<meta property="og:image" content="<?= $seo['image'] ?>">
	<meta property="og:image:width" content="550" />
	<meta property="og:image:height" content="413" />

	<meta property="twitter:card" content="summary">
	<meta property="twitter:site" content="woodieodotcom">
	<meta property="twitter:title" content="<?= $seo['title'] ?>">
	<meta property="twitter:description" content="<?= $seo['description'] ?>">
	<meta property="twitter:image" content="<?= $seo['image'] ?>">
	<meta property="twitter:url" content="{{ url()->current() }}">
	<meta name="twitter:domain" content="woodieo">

	<link rel="alternate" href="">
	<meta itemprop="name" content="<?= $seo['title'] ?>">
	<meta itemprop="description" content="<?= $seo['description'] ?>" >
	@endif

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('front/css/bootstrap4.3.1/bootstrap.min.css') }}" crossorigin="anonymous">
	<!-- link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css' -->
	<link href='https://fonts.googleapis.com/css?family=Sansita' rel='stylesheet'>

	<script src="{{ asset('front/js/font/fontawesome.js') }}" crossorigin="anonymous"></script>

	<!-- Ajax Jquery -->
	<script src="{{ asset('front/js/jquery3.6.0/jquery.min.js') }}"></script>



	<!--Toastr 2.0.1 -->
	<!-- link rel="stylesheet" href="{{ asset('front/toastr/toastr.css') }}">
	<link rel="stylesheet" href="{{ asset('front/toastr/toastr.js') }}" -->

	<!--Toastr -->
	<!-- link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" / -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<link rel="stylesheet" href="{{ asset('front/css/style.css') }}">


	<script>
		var url = "{{ url('/') }}";
	</script>



	@yield('custom_css')

</head>

<body class="bg-white">

	<nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
			aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="fa fa-bars"></span>
		</button>
		<a class="navbar-brand" href="{{ url('/') }}"><img class="logo" src="{{ config('const.site_setting.logo') }}" alt="{{ config('const.site_setting.name') }} Logo" /></a>
		<div class="search order-lg-last">
			<input type="text" name="" id="serach_txt" placeholder="Search Product Brand And More" />
			<i class="fa-solid fa-magnifying-glass pr-2"></i>
			<i class="fa-solid fa-xmark search-close m-show pl-2 text-primary" style="font-size: 20px;"></i>

			<div class="serach_res">
				<div class="item">
					<a href="#">No Result</a>
				</div>

			</div>
		</div>

		<!-- search end -->
		<div class="nav-icons order-lg-last">
			<div class="mb-0 d-flex">
				<a href="#" class="d-flex align-items-center justify-content-center search-icon" aria-label="search"><i class="fa-solid fa-magnifying-glass"></i></a>
				@if(Auth::check())

				@php
				$count = get_count();
				@endphp

				<div class="dropdown m-hide">
					<div class=" dropdown-toggle" data-toggle="dropdown" id="profileDropdown" aria-expanded="true" aria-label="profile">
						<i class="fa-regular fa-circle-user" style="font-size: 20px;"></i>
					</div>
					<div class="dropdown-menu dropdown-menu1" aria-labelledby="navbarDropdown">
						<!-- a class="dropdown-item" href="#">Account</a -->
						<a class="dropdown-item" href="{{ route('account.profile') }}">Profile</a>
						<a class="dropdown-item" href="{{ route('account.change_password') }}">Change Password</a>
						<a class="dropdown-item" href="{{ route('account.order') }}">Orders</a>
						<a class="dropdown-item" href="{{ route('account.wishlist') }}">Wishlist</a>
						<!-- <a class="dropdown-item" href="{{ route('account.address') }}">Address</a> -->
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" onclick="$('#logout-form').submit()" href="#">LogOut</a>
					</div>
				</div>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
				<a href="{{ route('account.wishlist') }}" class="d-flex align-items-center justify-content-center pos" aria-label="wishlist">
					<i class="fa-regular fa-heart">@if($count['wishlist_count'] >0)<span class="badge badge-pill badge-danger hart-badge">{{ $count['wishlist_count'] }}</span> @endif</i>
				</a>

				<a href="{{ route('cart') }}" class="d-flex align-items-center justify-content-center pos" aria-label="cart">
					<i class="fa-solid fa-bag-shopping">@if($count['cart_count'] >0)<span class="badge badge-pill badge-danger shopping-badge">{{ $count['cart_count'] }}</span> @endif </i>
				</a>
				@else
				<a href="#" class="d-flex align-items-center justify-content-center m-hide pos" data-toggle="modal" data-target="#authmodal" aria-label="profile"><i class="fa-regular fa-circle-user" style="font-size: 20px;"></i></a>
				<a href="#" class="d-flex align-items-center justify-content-center pos" data-toggle="modal" data-target="#authmodal" aria-label="wishlist">
					<i class="fa-regular fa-heart"></i>
				</a>
				<a href="#" class="d-flex align-items-center justify-content-center pos" data-toggle="modal" data-target="#authmodal" aria-label="cart">
					<i class="fa-solid fa-bag-shopping"></i>
				</a>
				@endif

			</div>
		</div>

		<div class="collapse navbar-collapse" id="ftco-nav">
			<ul class="navbar-nav ml-auto mr-md-3">
				<li class="nav-item {{ (request()->is('Home') || request()->is('/')) ? 'active' : '' }}"><a href="{{ url('/') }}" class="nav-link text-center">Home</a></li>
				<li class="nav-item {{ (request()->is('products')) ? 'active' : '' }}"><a href="{{ url('/products') }}" class="nav-link text-center">Product</a></li>
				<!-- <li class="nav-item {{ (request()->is('Home') || request()->is('collections')) ? 'active' : '' }}"><a href="{{ url('/collections') }}" class="nav-link text-center">Collections</a></li> -->
				<li class="nav-item {{ (request()->is('AboutUs')) ? 'active' : '' }}"><a href="{{ url('/AboutUs') }}" class="nav-link text-center">About Us</a></li>
				<li class="nav-item {{ (request()->is('ContactUs')) ? 'active' : '' }}"><a href="{{ url('/ContactUs') }}" class="nav-link text-center">Contact Us</a></li>
				<li class="nav-item {{ (request()->is('FAQ')) ? 'active' : '' }}"><a href="{{ url('/FAQ') }}" class="nav-link text-center">FAQ</a></li>
				<!-- <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  Support
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					  <a class="dropdown-item {{ (request()->is('FAQ')) ? 'active' : '' }}" href="{{ url('/FAQ') }}">FAQs</a>
					  <a class="dropdown-item" href="#">Help & Support</a>
					  <a class="dropdown-item {{ (request()->is('ShippingMethod')) ? 'active' : '' }}" href="{{ url('/ShippingMethod') }}">Shipping Method</a>
					  <a class="dropdown-item {{ (request()->is('PaymentMethod')) ? 'active' : '' }}" href="{{ url('/PaymentMethod') }}">Payment Method</a>
					  <a class="dropdown-item {{ (request()->is('OrderTracking')) ? 'active' : '' }}" href="{{ url('/OrderTracking') }}">Order Tracking</a>
					</div>
				  </li> -->
			</ul>
		</div>
	</nav>


	<!-- END nav -->
	<div style="min-height: 40vh;">

		@yield('content')

	</div>

	<!---------------- Login And Register Modal Start----------->

	<div class="modal fade" id="authmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">

				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="classic-tabs">
						<ul class="nav tabs-cyan" id="myClassicTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link waves-light waves-effect waves-light active show" id="login-tab-classic" data-toggle="tab" href="#login-classic" role="tab" aria-controls="login-classic" aria-selected="true">login</a>
							</li>
							<li class="nav-item">
								<a class="nav-link waves-light waves-effect waves-light" id="register-tab-classic" data-toggle="tab" href="#register-classic" role="tab" aria-controls="register-classic" aria-selected="false">Register</a>
							</li>
							<li class="nav-item">
								<a class="nav-link waves-light waves-effect waves-light " id="forgot-tab-classic" data-toggle="tab" href="#forgot-classic" role="tab" aria-controls="forgot-classic" aria-selected="false">Forgot Password</a>
							</li>
						</ul>
						<div class="tab-content pt-3" id="myClassicTabContent">
							<div class="tab-pane fade active show" id="login-classic" role="tabpanel" aria-labelledby="login-tab-classic">
								<p class="h4 mb-3 font-weight-bold">Login</p>
								<form action="{{ route('login-submit') }}" id="login_form" class="row">{{ csrf_field() }}

									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="email" name="email" class="form-control" placeholder="Your Email *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="password" name="password" class="form-control" placeholder="Password *">
									</div>


									<div class="form-check col-lg-12 col-md-12 col-12 ml-3">
										<input type="checkbox" class="form-check-input" id="exampleCheck1">
										<label class="form-check-label" for="exampleCheck1">Remember me</label>
									</div>
									<div class="form-check col-lg-12 col-md-12 col-12 text-right">
										<button type="submit" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button">Login</button>
										<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button loading" style="display:none;">Loading ...</button>
									</div>
								</form>
							</div>
							<div class="tab-pane fade" id="register-classic" role="tabpanel" aria-labelledby="register-tab-classic">
								<p class="h4 mb-3 font-weight-bold">Register</p>
								<form action="{{ route('user.register') }}" id="register_form" class="row">{{ csrf_field() }}

									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="text" name="first_name" class="form-control" placeholder="Your First Name *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="text" name="last_name" class="form-control" placeholder="Your Last Name *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="number" name="mobile_no" class="form-control" placeholder="Your Mobile Number *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="email" name="email" class="form-control" placeholder="Your Email *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="password" name="password" class="form-control" placeholder="Password *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12">
										<p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.</p>
									</div>



									<div class="form-check col-lg-12 col-md-12 col-12 text-right">
										<button type="submit" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button">Register</button>
										<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button loading" style="display:none;">Loading ...</button>
									</div>
								</form>
							</div>
							<div class="tab-pane fade " id="forgot-classic" role="tabpanel" aria-labelledby="forgot-tab-classic">
								<p class="h4 mb-3 font-weight-bold mb-3">Forgot Passwor</p>
								<form action="{{ route('reset_password') }}" id="reset_form" class="row">{{ csrf_field() }}


									<div class="form-group col-lg-12 col-md-12 col-12">
										<input type="email" name="email" id="forgot_email" class="form-control" placeholder="Your Email *">
										<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 forgot_button submit_button">Forgot</button>
										<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button loading" style="display:none;">Loading ...</button>
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12 pass-div">
										<input type="text" name="pin" class="form-control" placeholder="Enter Code *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12 pass-div">
										<input type="password" name="password" class="form-control" placeholder="Password *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12 pass-div">
										<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password *">
									</div>

									<div class="form-group col-lg-12 col-md-12 col-12">
										<p>Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.</p>
									</div>



									<div class="form-check col-lg-12 col-md-12 col-12 text-right pass-div">
										<button type="submit" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button">Reset</button>
										<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button loading" style="display:none;">Loading ...</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div -->
			</div>
		</div>
	</div>

	<!---------------- Login And Register Modal End----------->



	@include('front/layouts/bottomtabs')

	<!-- footer start-->
	<footer class="text-center text-lg-start ">
		<div class="row">
			<div class="col-lg-4 col-md-6 mb-4 mb-lg-0 text-center info">
				<img src="{{ config('const.footer.logo') }}" class="footerlogo" alt="{{ config('const.site_setting.name') }} Logo" />
				<p>{{ config('const.footer.description') }}</p>

				<h5 class="text-uppercase mb-2 font-weight-bold mt-5">Follow Us</h5>
				<div class="media">
					@php
					$social = App\Models\Setting::select('Facebook', 'Instagram', 'LinkedIn', 'YouTube', 'Twitter')->first();
					@endphp

					@if($social->Facebook) <a href="{{ $social->Facebook }}" class="btn btn-floating btn-light btn-lg" aria-label="facebook"><i class="fab fa-facebook-f"></i></a>@endif
					@if($social->Instagram) <a href="{{ $social->Instagram }}" class="btn btn-floating btn-light btn-lg" aria-label="instagram"><i class="fa fa-instagram"></i></i></a>@endif
					@if($social->LinkedIn) <a href="{{ $social->LinkedIn }}" class="btn btn-floating btn-light btn-lg" aria-label="linkedin"><i class="fa fa-linkedin"></i></i></a>@endif
					@if($social->YouTube) <a href="{{ $social->YouTube }}" class="btn btn-floating btn-light btn-lg" aria-label="youtube"><i class="fa fa-youtube"></i></a>@endif
					@if($social->Twitter) <a href="{{ $social->Twitter }}" class="btn btn-floating btn-light btn-lg" aria-label="twitter"><i class="fab fa-twitter"></i></a> @endif
				</div>
			</div>
			<div class="col-lg-2 col-md-6 mb-4 mb-lg-0 links">
				<h5 class="text-uppercase mb-4 font-weight-bold h6">Useful Links</h5>

				<ul class="list-unstyled mb-4">
					<li> <a @if(Auth::check()) href="{{ route('account.order') }}" @else href="#!" data-toggle="modal" data-target="#authmodal" @endif>Order History</a> </li>
					<!-- <li><a href="#!">Customer Services</a></li> -->
					<!--li><a href="#!" >My Account</a></li></li -->
					@foreach (getLagelages() as $lpage)
					<li><a href="{{ route($lpage->page_type) }}">{{ formatString($lpage->page_type) }}</a></li>
					@endforeach
					
					<li><a href="{{ url('/ContactUs') }}">Contact Us</a></li>
				</ul>
			</div>

			<div class="col-lg-2 col-md-6 mb-4 mb-lg-0  links">
				<h5 class="text-uppercase mb-4 font-weight-bold h6">Popular Categories</h5>
				<ul class="list-unstyled">
					@foreach(getMainCategories() as $cat)
					<li>
						<a href="{{ route('Products') }}?category={{ $cat->slug }}">{{ strtoupper($cat->name) }}</a>
					</li>
					@endforeach
				</ul>
			</div>

			<div class="col-lg-4 col-md-6 mb-4 mb-lg-0 text-left links">
				<h5 class="text-uppercase mb-4 font-weight-bold h6">Contacts</h5>
				<ul class="list-unstyled">
					<li class="mb-3">
						<a href="#!"><i class="fa-regular fa-building pr-1"></i> {{ config('const.footer.contact.address') }} </a>
					</li>
					<li class="mb-3">
						<a href="tel:+91{{ config('const.contact.contact') }}">
							<i class="fa-regular fa-id-badge pr-1"></i>
							+91 {{ config('const.footer.contact.contact') }}
						</a>
					</li>
					<li class="mb-3">
						<a href="mailto:{{ config('const.contact.email') }}"><i class="fa-regular fa-envelope pr-1"></i> {{ config('const.footer.contact.email') }}</a>
					</li>
				</ul>

				<!-- <h5 class="text-uppercase mb-3 font-weight-bold h6 mt-4">Keep in Touch</h5>
				<div class="form-outline form-white mb-4">
					<input type="email" id="ee" class="form-control" aria-label="email" placeholder="Email" />
				</div> -->
			</div>
			<!--Grid column-->
		</div>
		<!--Grid row-->
	</footer>
	<!-- footer end-->
	<!-- Copyright -->
	<div class="copyright text-left p-2 border-top border-white">
		© {{ date('Y') }} Copyright, All rights reserved
	</div>
	<!-- Copyright -->

	<script src="{{ asset('front/js/jquery.min.js') }}"></script>
	<script src="{{ asset('front/js/popper.js') }}"></script>
	<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('front/js/main.js') }}"></script>



	<!-- header search script -->
	<script>
		$(".search-icon").click(function() {
			$(".nav-icons").css("display", "none");
			$(".navbar-brand").css("display", "none");
			$(".navbar-toggler").css("display", "none");
			$(".search-close").css("display", "flex");
			$(".search").css("display", "flex");
		});
		$(".search-close").click(function() {
			$(".nav-icons").css("display", "flex");
			$(".navbar-brand").css("display", "flex");
			$(".navbar-toggler").css("display", "flex");
			$(".search-close").css("display", "none");
			$(".search").css("display", "none");
		});

		$('#serach_txt').focusout(function() {
			setTimeout(function() {
				$('.serach_res').hide();
				$('#home-slider').removeClass('home-slider');
			}, 300);

		});

		$('#serach_txt').keyup(function() {
			$.ajax({
				url: url + '/get_search_result',
				type: "POST",
				data: {
					'text': $('#serach_txt').val(),
				},
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				beforeSend: function() {
					$('.serach_res').show();
					$('.serach_res').html('<div class="item"> <a href="#">Search... </a> </div>');
					$('#home-slider').addClass('home-slider');
				},
				success: function(result) {
					//console.log(data);

					$('.serach_res').html(result.html);
				},
				error: function(e) {
					toastr.error('Somthing Wrong');
					console.log(e);
				}
			});
		});
	</script>

	@yield('custom_js')

	<!-- login and register script -->
	<script>
		$(document).ready(function() {
			// Close navbar when clicking outside
			$(document).click(function(event) {
				var clickover = $(event.target);
				var navbarOpen = $("#ftco-nav").hasClass("show");
				if (navbarOpen && !clickover.closest(".navbar-toggler, .navbar-collapse").length) {
					// $("#ftco-nav").removeClass("show");
					$(".navbar-toggler").click();

				}
			});
		});

		//$('#authmodal').modal('show');
		$(".forgot_button").on('click', (function(e) {
			$.ajax({
				url: "{{ route('forgot') }}",
				type: "POST",
				data: {
					'email': $('#forgot_email').val(),
				},
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				beforeSend: function() {
					$('.forgot_button').hide();
					$('.loading').show();
				},
				success: function(result) {
					//console.log(data);

					if (result.success) {
						toastr.success(result.message);
						$('.forgot_button').html('Resend Code');
						$('.pass-div').show();
					} else {
						toastr.error(result.message);
					}
					$('.forgot_button').show();
					$('.loading').hide();
				},
				error: function(e) {
					toastr.error('Something Wrong');
					console.log(e);
					$('.forgot_button').show();
					$('.loading').hide();
				}
			});
		}));

		$("#reset_form").on('submit', (function(e) {
			e.preventDefault();
			var form = this;
			$.ajax({
				url: this.action,
				type: "POST",
				data: new FormData(this),
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.submit_button').hide();
					$('.loading').show();
				},
				success: function(result) {
					//console.log(data);

					if (result.success) {
						toastr.success(result.message);
						location.reload();
					} else {
						toastr.error(result.message);
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e) {
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}
			});
		}));

		$("#login_form").on('submit', (function(e) {
			e.preventDefault();
			var form = this;
			$.ajax({
				url: this.action,
				type: "POST",
				data: new FormData(this),
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.submit_button').hide();
					$('.loading').show();
				},
				success: function(result) {
					// console.log(result);

					if (result.success) {
						toastr.success(result.message);
						location.reload();
					} else {
						toastr.error(result.message);
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e) {
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}
			});
		}));

		$("#register_form").on('submit', (function(e) {
			e.preventDefault();
			var form = this;
			$.ajax({
				url: this.action,
				type: "POST",
				data: new FormData(this),
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.submit_button').hide();
					$('.loading').show();
				},
				success: function(result) {
					//console.log(data);

					if (result.success) {
						toastr.success(result.message);
						form.reset();
					} else {
						toastr.error(result.message);
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e) {
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}
			});
		}));
	</script>


</body>

</html>