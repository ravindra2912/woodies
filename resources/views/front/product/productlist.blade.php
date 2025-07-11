@extends('front.layouts.index', ['seo' => [
'title' => 'shop',
'description' => 'shop',
'keywords' => 'shop' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])


@section('content')

<style>
	#products .nav-link {
		cursor: pointer;
	}

	#products .nav-link[data-toggle].collapsed:after {
		content: "+";
		float: right;
		color: var(--primary);
	}

	#products .nav-link[data-toggle]:not(.collapsed):after {
		content: "-";
		float: right;
		color: var(--primary);
	}

	#products .text-truncate {
		color: var(--primary);
	}

	#products .collapsed {
		color: gray;
	}

	.sort-select {
		border: unset;
		font-size: 20px;
		font-weight: 900;
	}

	.cc:not(.show) {
		display: block;
	}

	@media only screen and (max-width: 600px) {
		.cc:not(.show) {
			display: none;
		}

		.col,
		.col-1,
		.col-10,
		.col-11,
		.col-12,
		.col-2,
		.col-3,
		.col-4,
		.col-5,
		.col-6,
		.col-7,
		.col-8,
		.col-9,
		.col-auto,
		.col-lg,
		.col-lg-1,
		.col-lg-10,
		.col-lg-11,
		.col-lg-12,
		.col-lg-2,
		.col-lg-3,
		.col-lg-4,
		.col-lg-5,
		.col-lg-6,
		.col-lg-7,
		.col-lg-8,
		.col-lg-9,
		.col-lg-auto,
		.col-md,
		.col-md-1,
		.col-md-10,
		.col-md-11,
		.col-md-12,
		.col-md-2,
		.col-md-3,
		.col-md-4,
		.col-md-5,
		.col-md-6,
		.col-md-7,
		.col-md-8,
		.col-md-9,
		.col-md-auto,
		.col-sm,
		.col-sm-1,
		.col-sm-10,
		.col-sm-11,
		.col-sm-12,
		.col-sm-2,
		.col-sm-3,
		.col-sm-4,
		.col-sm-5,
		.col-sm-6,
		.col-sm-7,
		.col-sm-8,
		.col-sm-9,
		.col-sm-auto,
		.col-xl,
		.col-xl-1,
		.col-xl-10,
		.col-xl-11,
		.col-xl-12,
		.col-xl-2,
		.col-xl-3,
		.col-xl-4,
		.col-xl-5,
		.col-xl-6,
		.col-xl-7,
		.col-xl-8,
		.col-xl-9,
		.col-xl-auto {

			position: unset;
		}

		.close-filter {
			font-size: 35px;
			padding: 10px;
		}

		.navbar-collapse {
			/*position: absolute;*/
			position: unset;
			top: auto;
			left: 100%;
			padding-left: 15px;
			padding-right: 15px;
			padding-bottom: 15px;
			width: 100%;
			transition: all 0.4s ease;
			display: block;
			background: white;
			border-bottom: 2px solid var(--primary);
			border-top: 2px solid var(--primary);
		}

		.navbar-collapse.collapsing {
			height: auto !important;
			margin-left: 50%;
			left: 50%;
			transition: all 0.2s ease;
		}

		.navbar-collapse.show {
			left: 0;
		}

	}

	/* pagination */
	.pagination .page-item .page-link {
		margin: 0px 5px;
		border-radius: 48px;
		padding: 3px 17px 5px 18px;
		font-size: 30px;
		color: var(--primary);
		box-shadow: 1px 2px 9px var(--primary);
		border: unset;
	}

	.pagination .active .page-link {
		color: #ffffff;
		background: var(--primary);
	}





	/*  filter */


	input[type="radio"] {
		opacity: 0;
		position: absolute;
	}

	input[name="brand"]:checked+label {
		color: var(--primary) !important;
	}

	input[name="color"]:checked+label,
	input[name="size"]:checked+label {
		background: var(--secondary) !important;
		color: var(--primary) !important;
	}

	.style1 {
		background: #D9D9D9;
		color: rgba(0, 0, 0, 0.5);
		padding: 0px 4px;
		border-radius: 3px;
	}

	.h5 {
		font-family: 'Sansita';
		font-weight: 800;
		font-size: 25px;
		line-height: 42px;
		text-transform: capitalize;
	}
</style>

<!-- <section id="nevigation-header">
		<h3>Our Shop</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Shop</p>
	</section> -->

<section id="products" class="mt-5 mb-5 pb-5">
	<div class="container">
		<div class="row">

			{{--
				<div class="col-lg-3 col-md-3 col-0 collapse navbar-collapse cc" id="mobile-filter">
					
					<div class="m-show text-right mb-2">
						<span class="float-left pt-3 h5">Filters</span>
						<i class="fa-solid fa-xmark close-filter text-primary" onclick="$('#filter-btn').click();"> </i>
					</div>
					
					<a href="{{ route('Products') }}" class="clear-filter btn btn-primary btn-round btn-sm mb-3" style="display:none;">Clear Filter <i class="fa-solid fa-xmark ml-1 pt-1"></i></a>

			<!-- Category Start -->
			<p class="h5"> <i class="fa-solid fa-caret-right text-primary"></i> Item Categories</p>
			<ul class="nav flex-column flex-nowrap overflow-hidden">
				@foreach($Categoreis as $cat)
				@if(isset($cat->sub_cat) && count($cat->sub_cat) > 0)
				<li class="nav-item">
					<a class="nav-link text-truncate collapsed" href="#submenu{{ $cat->id }}" data-toggle="collapse" data-target="#submenu{{ $cat->id }}">
						<span onclick="set_category_data({{ $cat->id }})" class=" d-sm-inline">{{ $cat->name }}</span>
					</a>
					<div class="collapse" id="submenu{{ $cat->id }}" aria-expanded="false">
						<ul class="flex-column pl-2 nav">
							@foreach($cat->sub_cat as $cat2)
							@if(isset($cat2->children) && count($cat2->children) > 0)
							<li class="nav-item">
								<a class="nav-link  text-truncate collapsed py-1" href="#submenu1sub{{ $cat2->id }}" data-toggle="collapse" data-target="#submenu1sub{{ $cat2->id }}">
									<span onclick="set_category_data({{ $cat2->id }})">{{ $cat2->name }}</span>
								</a>
								<div class="collapse" id="submenu1sub{{ $cat2->id }}" aria-expanded="false">
									<ul class="flex-column nav pl-4">
										@foreach($cat2->children as $cat3)
										<li class="nav-item">
											<span class="nav-link p-1 text-truncate" href="#" onclick="set_category_data({{ $cat3->id }})"> {{ $cat3->name }} </span>
										</li>
										@endforeach
									</ul>
								</div>
							</li>
							@else
							<li class="nav-item"><a class="nav-link py-0" href="#" style="color: gray;"><span>{{ $cat2->name }}</span></a></li>
							@endif
							@endforeach
						</ul>
					</div>
				</li>
				@else
				<li class="nav-item"><a class="nav-link text-truncate" href="#" style="color: gray;">
						<span class=" d-sm-inline">{{ $cat->name }}</span></a>
				</li>
				@endif
				@endforeach
			</ul>
			<!-- Category End -->


			@if(isset($sizes) && !empty($sizes))
			<p class="h5 mt-4 mb-3"> <i class="fa-solid fa-caret-right text-primary"></i> Size</p>
			<div>
				@foreach($sizes as $val)
				<input type="radio" name="size" value="{{ $val->variant }}" id="size{{ $val->id }}" class="data-changes" />
				<label for="size{{ $val->id }}" class="style1">{{ $val->variant }}</label>

				@endforeach
			</div>
			@endif

			@if(isset($colors) && !empty($colors))
			<p class="h5 mt-4 mb-3"> <i class="fa-solid fa-caret-right text-primary"></i> Color</p>
			<div>
				@foreach($colors as $val)
				<input type="radio" name="color" value="{{ $val->variant }}" id="color{{ $val->id }}" class="data-changes" />
				<label for="color{{ $val->id }}" class="style1">{{ $val->variant }}</label>

				@endforeach
			</div>
			@endif

			@if(isset($brands) && !empty($brands))
			<p class="h5 mt-4 mb-3"> <i class="fa-solid fa-caret-right text-primary"></i> Brand Name</p>
			<div>
				@foreach($brands as $brand)
				<div>
					<input type="radio" name="brand" value="{{ $brand->brand }}" id="brand{{ $brand->id }}" class="data-changes" />
					<label for="brand{{ $brand->id }}" class="text-muted">{{ $brand->brand }}</label>
				</div>
				@endforeach
			</div>
			@endif
		</div>
		--}}
		<!-- <div class="col-lg-9 col-md-9 col-12 pos"> -->
		<div class="col-lg-12 col-md-12 col-12 pos">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-12">
					<!-- <div class="m-show float-right mb-3">
						<button id="filter-btn" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#mobile-filter" aria-expanded="false" aria-controls="mobile-filter">Filters<span class="fa fa-filter pl-1"></span></button>
					</div> -->
					<div class="float-right sorting d-none">
						<span>Sort By
							<select class="sort-select data-sort" id="sortby">
								<option value="0">Default Sorting</option>
								<option value="2" @if($request->sortby == 2) selected @endif>Price High To Low</option>
								<option value="1" @if($request->sortby == 1) selected @endif>Price Low To High</option>
							</select>
						</span>
						<!-- <span><i class="fa-solid fa-border-all pr-2 pl-3 text-primary"></i> </span>
								<span><i class="fa-solid fa-list-ul "></i> </span> -->

					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-12 pos">
					<div class="row" id="product_data">

					</div>
					<div class="row mt-4 d-none" id="product_loader">
						<div class="col-12 text-center">
							<div class="spinner-border" role="status">
								<span class="visually-hidden"></span>
							</div>
						</div>
					</div>
					<div id="productNotFound" class="text-center d-none">
						<p class="h3">Product not found!</p>

					</div>
					<div id="scroll-sentinel"></div>
				</div>

			</div>
		</div>

	</div>
	</div>
</section>





@endsection


@section('custom_js')
<script>
	$(document).ready(function() {
		var page = 0;
		var is_loading = false;
		var dataEmpty = false;
		var category = '';
		const params = new URLSearchParams(window.location.search);
		category = params.get('category');



		function set_category_data(cat) {
			category = cat;
			page = 0;
			$('.clear-filter').show();
		}

		$('.data-sort').change(function() {
			page = 0;
			$('.clear-filter').show();
			$('#product_data').html('');
			load_product_data();
		});


		function load_product_data() {
			if(is_loading || dataEmpty){
				return;
			}
			$.ajax({
				url: '{{ route("Products.render_product_list") }}',
				type: "post",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				data: {
					'page': page,
					'category': category,
					'sortby': $('#sortby').val(),
					'brand': $('input[name=brand]:checked').val(),
					'color': $('input[name=color]:checked').val(),
					'size': $('input[name=size]:checked').val(),
				},
				dataType: "json",
				beforeSend: function() {
					is_loading = true;
					$('#product_loader').removeClass('d-none');
				},
				success: function(result) {
					if (result.success) {
						$('.loading-btn').hide();
						//toastr.success(result.message);
						$('#product_data').append(result.data);
						if(page > 0 && result.data.trim() == ''){
							dataEmpty = true;
						}

						if(page == 0 && result.data.trim() == ''){
							$('#productNotFound').removeClass('d-none');
							$('.sorting').addClass('d-none');
						} else {
							$('#productNotFound').addClass('d-none');
							$('.sorting').removeClass('d-none');
						}
						page += 1;
					} else {
						toastr.error(result.message);
					}
					$('#product_loader').addClass('d-none');
					is_loading = false;
				},
				error: function(e) {
					is_loading = false;
					$('#product_loader').addClass('d-none');
					toastr.error('Something Wrong!');
					console.log(e);
				}
			});
		}

		// load_product_data();

		const sentinel = document.getElementById("scroll-sentinel");
		// Create the IntersectionObserver
		const observer = new IntersectionObserver((entries) => {
			if (entries[0].isIntersecting) {
				// When sentinel is in view, load more content
				load_product_data();
			}
		}, {
			rootMargin: "100px", // Start loading before reaching the end
		});

		// Start observing the sentinel
		observer.observe(sentinel);
	})
</script>

@endsection