@extends('front.layouts.index', ['seo' => [
'title' => $product->name,
'description' => $product->SEO_description,
'keywords' => $product->SEO_tags ,
'image' => getImage(isset($product->images_data) && count($product->images_data) > 0 ? $product->images_data[0]->image:'') ,
'city' => '',
'state' => '',
'position' => ''
]
])


@section('custom_css')

<style>
	#product-detail .main-image {
		width: -webkit-fill-available;
		height: 350px;
		object-fit: contain;

		padding: 10px;
		background: #F8F8F8;
		border-radius: 10px;
	}

	#product-detail .imgs {
		display: flex;
		margin-top: 20px;
		overflow: overlay;
	}

	#product-detail .imgs img {
		width: 150px;
		height: 150px;
		object-fit: contain;
		padding: 10px;
		border-radius: 10px;
		background: #F8F8F8;
		border-radius: 10px;
		margin-right: 8px;
	}

	#product-detail .cart-qty {
		border: 1px solid var(--primary);
		border-radius: 15px;
		width: max-content;
		padding: 2px 10px;
		color: var(--primary);
	}

	#product-detail .cart-qty span {
		padding: 0px 5px;
		font-size: 20px;
		cursor: pointer;
	}

	#product-detail .cart-qty span i {
		padding: 0px 5px;
	}

	#product-detail .cart-qty span input {
		width: 10%;
		text-align: center;
		border: unset;
	}

	.btn-feverit,
	.btn-feverits {
		border: 1px solid #9A9A9A;
		background: white;
		border-radius: 20px;
		padding: 8px 8px 5px 8px;
		font-size: 20px;
		color: #9A9A9A;
		cursor: grab;
		margin: 0px 0px 0px 12px;
	}

	.fev-active,
	.btn-feverit:hover {
		border-color: var(--primary);
		color: var(--primary);
	}




	/*review star */

	.rate {
		float: left;
		height: 46px;
		padding: 0 10px;
	}

	.rate:not(:checked)>input {
		position: absolute;
		opacity: 0;
	}

	.rate:not(:checked)>label {
		float: right;
		width: 1em;
		overflow: hidden;
		white-space: nowrap;
		cursor: pointer;
		font-size: 30px;
		color: #ccc;
	}

	.rate:not(:checked)>label:before {
		content: '★ ';
	}

	.rate>input:checked~label {
		color: #ffc700;
	}

	.rate:not(:checked)>label:hover,
	.rate:not(:checked)>label:hover~label {
		color: #deb217;
	}

	.rate>input:checked+label:hover,
	.rate>input:checked+label:hover~label,
	.rate>input:checked~label:hover,
	.rate>input:checked~label:hover~label,
	.rate>label:hover~input:checked~label {
		color: #c59b08;
	}

	/* variants */
	.variants {
		display: flex;
		width: max-content;
		flex-wrap: wrap;
	}

	.rat-contin {
		border-bottom: 1px solid var(--secondary);
		margin-bottom: 15px;
	}

	#review-list img {
		height: 65px;
		width: 65px;
		object-fit: contain;
		border-radius: 100%;
	}
</style>

<!-- image zoom -->
<style type="text/css">
	/* Zoom styles */
	.zoom,
	.original {
		position: relative;
	}

	.zoom {
		display: inline-block;
	}

	.original {
		cursor: crosshair;
	}

	#target {
		width: -webkit-fill-available;
		height: 350px;
		object-fit: contain;
	}

	.zoom .viewer {
		position: absolute;
		top: 0;
		left: 100%;
		width: 100%;
		height: 100%;
		overflow: hidden;
		background: white;
	}

	.zoom .viewer img {
		position: absolute;
	}

	.magnifier {
		position: absolute;
		background: #000;
		opacity: 0.7;
		top: 0;
		left: 0;
	}

	.magnifier,
	.viewer {
		display: none;
	}

	.original:hover~div {
		display: block;
	}

	.original::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 1;
	}
</style>
@endsection

@section('content')

<!-- <section id="nevigation-header">
	<h3>Product Details</h3>
	<p>Shop <i class="fa-solid fa-angle-right"></i> {{ $product->name }}</p>
</section> -->

<section id="product-detail" class="mt-5 mb-5 pb-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-12 position-relative">

				<!-- share -->
				<style>
					.share {
						position: absolute;
						top: 6px;
						right: 25px;
						border: 1px solid;
						font-size: 20px;
						border-radius: 100%;
						padding: 6px 7px;
					}
				</style>

				<i data-toggle="modal" data-target="#sharemodal" class="share fa-solid fa-share-alt"></i>


				<img loading="lazy" class="main-image m-show" src="{{ getImage(isset($product->images_data) && count($product->images_data) > 0 ? $product->images_data[0]->image:'') }}" alt="{{ $product->name }}" />



				<div class="m-hide" style="justify-content: center; display: flex; background: #f8f8f8; padding: 15px 5px;">
					<div class="zoom">
						<div class="original">
							<img loading="lazy" src="{{ getImage(isset($product->images_data) && count($product->images_data) > 0 ? $product->images_data[0]->image:'') }}" id="target" alt="{{ $product->name }}">
						</div>
						<!-- <div class="viewer">
							<img loading="lazy"  src="{{ getImage(isset($product->images_data) && count($product->images_data) > 0 ? $product->images_data[0]->image:'') }}" id="view-target" alt="{{ $product->name }}">
						</div> -->
						<div class="magnifier"></div>
					</div>
				</div>






				<div class="imgs">
					@if(isset($product->images_data) && count($product->images_data) > 0)
					@foreach($product->images_data as $imgs)
					<img loading="lazy" src="{{ getImage($imgs->image) }}" alt="{{ $product->name }}" />
					@endforeach
					@endif
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12 pl-2">
				<p class="h5 ">
					@if (!empty($product->categories) && count($product->categories) > 0)
					{{ $product->categories->pluck('name')->map(function ($name) {
												return ucfirst($name);
											})->implode(', ') }}
					@endif
				</p>



				<h3 class="font-weight-bold">{{ $product->name }}</h3>
				@if($product->stock == 1)
				<div class="d-flex">
					<p class="h3 font-weight-bold text-primary price-text pr-3">Rs. {{ $product->price }}</p>
					<p class="h3 font-weight-bold  price-text" style="color:#9A9A9A"><del>Rs. {{ $product->price }}</del></p>
				</div>
				@endif
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12">
						@for( $i=1; $i<=5; $i++)
							@if($product->rating >= $i)
							<i class="fa-solid fa-star text-warning"></i>
							@else
							<i class="fa-solid fa-star text-secondary"></i>
							@endif
							@endfor

							<span>{{ $product->review_count }} Reviews</span>
					</div>
					<div class="col-lg-6 col-md-6 col-12">
						<p><b>Available :</b> @if($product->stock == 1) <span class="text-success">In Stock</span> @else <span class="text-danger"> Out Of Stock @endif</span></p>
					</div>
					<div class="col-lg-12 col-md-12 col-12">
						<p>{{ $product->short_description }}</p>
					</div>

					@if($product->stock == 1)
					<div class="col-lg-12 col-md-12 col-12">
						<form action="{{ route('cart.add_to_cart') }}" id="addtocart" method="post" class="row" />{{ csrf_field() }}
						<input type="hidden" name="product_id" value="{{ $product->id }}" />
						@if($product->is_variants == 1)
						@if(isset($product->variants) && !empty($product->variants) && count($product->variants) > 0 )
						<div class="col-lg-12 col-md-12 col-12 mt-3 ">
							<div class="variants mb-2">
								@php $c = 0; @endphp
								@foreach($product->variants as $vname)
								<div class="variants-conteiner mr-3">
									<p class="mb-1">{{ $vname->name }}</p>
									@if(isset($vname->variants_data) && !empty($vname->variants_data) && count($vname->variants_data) > 0 )
									<select class="form-control variants-check" name="variants[{{ $vname->name }}]">
										@foreach($vname->variants_data as $vari)
										<option value="{{ $vari->variant }}" {{  ($product->available_variant[$c] == $vari->variant)? 'selected':'' }}>{{ $vari->variant }}</option>
										@endforeach
									</select>
									@endif
								</div>
								@php $c++; @endphp
								@endforeach
							</div>
						</div>
						@endif
						@endif
						<div class="col-lg-3 col-md-12 col-12 mt-3">
							<div class="cart-qty">
								<span><i class="fa-solid fa-minus qty-minus"></i></span>
								<span class="d-qyt">1</span>
								<span><i class="fa-solid fa-plus qty-plus"></i></span>
							</div>

						</div>
						<input type="hidden" id="input-qty" name="quantity" value="1" />
						<div class="col-lg-9 col-md-12 col-12 mt-3">
							@if(Auth::check())
							<button type="submit" class="btn btn-primary btn-round submit_button">ADD TO CART</button>
							<a href="{{ route('cart') }}" class="btn btn-primary btn-round gotocart-btn" style="{{ ($product->in_cart == 0)? 'display:none;':'' }}">GO TO CART</a>
							@else
							<button type="button" data-toggle="modal" data-target="#authmodal" class="btn btn-primary btn-round submit_button">ADD TO CART</button>
							@endif
							<button type="button" class="btn btn-primary btn-round loading" style="display:none;">Loading ...</button>
							<button type="button" class="btn btn-primary btn-round stock-out" style="display:none;">Out Of Stock</button>

							@if(Auth::check())
							<span class="btn-feverit {{ ($product->is_fevourit)? 'fev-active' :'' }}" id="{{ $product->id }}"><i class="fa-solid fa-heart"></i></span>
							@else
							<span class="btn-feverit" data-toggle="modal" data-target="#authmodal"><i class="fa-solid fa-heart"></i></span>
							@endif
						</div>
						</form>
					</div>
					@endif


				</div>
				<!-- <p class="mt-4"><b class="pr-2">ID :</b> 3489 JE0765-5</p> -->
				<p class="mt-3"><b class="pr-2">Tags :</b> {{ $product->SEO_tags }}</p>
			</div>
		</div>
	</div>
</section>

<section class="pb-3">
	<div class="container">
		<div class="classic-tabs">
			<ul class="nav tabs-cyan" id="myClassicTab">
				<li class="nav-item">
					<a class="nav-link waves-light waves-effect active show" id="Description-tab-classic" data-toggle="tab" href="#Description-classic" role="tab" aria-controls="Description-classic" aria-selected="true">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link waves-light waves-effect " id="Reviews-tab-classic" data-toggle="tab" href="#Reviews-classic" role="tab" aria-controls="Reviews-classic" aria-selected="false">Reviews ({{ $product->review_count }})</a>
				</li>

			</ul>
			<div class="tab-content pt-3" id="myClassicTabContent">
				<div class="tab-pane fade active show" id="Description-classic" role="tabpanel" aria-labelledby="Description-tab-classic">
					{!! $product->description !!}
				</div>
				<div class="tab-pane fade " name="review_form" id="Reviews-classic" role="tabpanel" aria-labelledby="Reviews-tab-classic">
					<div class="row ">
						<div class="col-lg-6 col-md-6 col-12 ">
							<h5>{{ $product->review_count }} reviews</h5>
							<div id="review-list">
							</div>

							<div class=" text-center">
								<button class="btn btn-primary load-more-btn">View More <i class="fa-solid fa-arrow-down pl-2"></i></button>
								<button class="btn btn-primary loading-btn" style="display:none;">Loading ...</i></button>
							</div>

						</div>
						<!-- <div class="col-lg-6 col-md-6 col-12">
							<form action="{{ route('Products.submit_review') }}" id="review_form" class="row review-form">{{ csrf_field() }}
								<input type="hidden" name="product" value="{{ $product->id }}" />
								<div class="form-group col-lg-12 col-md-12 col-12">
									<p class="h5 float-left mt-2">Your rating *</p>
									<div class="rate">
										<input type="radio" id="star5" name="rating" value="5" />
										<label for="star5" title="text">5 stars</label>
										<input type="radio" id="star4" name="rating" value="4" />
										<label for="star4" title="text">4 stars</label>
										<input type="radio" id="star3" name="rating" value="3" />
										<label for="star3" title="text">3 stars</label>
										<input type="radio" id="star2" name="rating" value="2" />
										<label for="star2" title="text">2 stars</label>
										<input type="radio" id="star1" name="rating" value="1" />
										<label for="star1" title="text">1 star</label>
									</div>
								</div>
								<div class="form-group col-lg-12 col-md-12 col-12">
									<input type="text" name="review_title" class="form-control" placeholder="Review Title *">
								</div>
								<div class="form-group col-lg-12 col-md-12 col-12">
									<textarea class="form-control" placeholder="Write your review *" rows="7" name="review"></textarea>
								</div>
								<div class="form-group col-lg-6 col-md-6 col-12">
									<input type="text" name="reviewer_name" class="form-control" placeholder="Your name *">
								</div>
								<div class="form-group col-lg-6 col-md-6 col-12">
									<input type="email" name="email" class="form-control" placeholder="Your Email *">
								</div>
								<div class="form-check col-lg-12 col-md-12 col-12 ml-3">
									<input type="checkbox" class="form-check-input" id="exampleCheck1">
									<label class="form-check-label" for="exampleCheck1">Save my name, email, and website in this browser for the next time I comment.</label>
								</div>
								@if(Auth::check())
								<button type="submit" class="btn btn-primary btn-round mt-3 ml-2 submit_button">Submit</button>
								@else
								<button type="button" data-toggle="modal" data-target="#authmodal" class="btn btn-primary btn-round mt-3 ml-2 submit_button">Submit</button>
								@endif
								<button type="button" class="btn btn-primary btn-round mt-3 ml-2 submit_button loading" style="display:none;">Loading ...</button>
							</form>
						</div> -->
					</div>

				</div>

			</div>

		</div>
	</div>
</section>

@if(isset($related_product) && !empty($related_product) && count($related_product)>0)
<section id="Recommended-product">
	<div class="container mt-5">
		<div class="row header-contaimer">
			<div class="col-lg-12 col-md-12 col-12">
				<h4 class="font-weight-bold">More Products Like This</h4>
			</div>

			@foreach($related_product as $val)
			<a href="{{ url('/products/'.$val->slug) }}" class="col-lg-3 col-md-3 col-6 mt-4 pos p-0">
				<div class="new-product">
					<div class="product-img">
						<img loading="lazy" class="product__single" src="{{ getImage(isset($val->images_data[0])?$val->images_data[0]->image:'') }}" alt="{{ $val->name }}">
						<img loading="lazy" class="secondary-img" src="{{ getImage(isset($val->images_data[1]) ? $val->images_data[1]->image:'') }}" alt="{{ $val->name }}">
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
						<p class="product-price mt-2">Rs. {{ $val->price }}</p>
					</div>
				</div>
			</a>
			@endforeach

		</div>
	</div>
</section>
@endif

<!---------------- Share Modal Start----------->

<div class="modal fade" id="sharemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Share</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-12 form-group">
						<input type="text" name="share_link" id="share_link" value="{{ url()->full() }}" class="form-control" readonly />
					</div>
					<div class="col-md-12 text-center">
						<button class="btn btn-outline-secondary copy" title="copy"><i class="far fa-copy"></i></button>
						<a href="https://wa.me/send?text= {{ url()->full() }}" data-action="share/whatsapp/share" target="_blank" class="btn btn-outline-success" title="Whatsapp"><i class="fab fa-whatsapp"></i></a>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!---------------- Share Modal End----------->


@endsection


@section('custom_js')
<script>
	// cart qty script
	$('.qty-plus').click(function() {
		var input_qty = $('#input-qty').val();
		input_qty++;
		$('#input-qty').val(input_qty);
		$('.d-qyt').html(input_qty);
	});
	$('.qty-minus').click(function() {
		var input_qty = $('#input-qty').val();
		if (input_qty > 1) {
			input_qty--;
			$('#input-qty').val(input_qty);
			$('.d-qyt').html(input_qty);
		}


	});

	$(".imgs img").click(function() {
		$('.main-image').attr('src', this.src);
		$('#target').attr('src', this.src);
		$('#view-target').attr('src', this.src);
	});

	$("document").ready(function() {

		//copy link
		$(".copy").on('click', (function(e) {
			var copyText = document.getElementById("share_link");
			copyText.select();
			copyText.setSelectionRange(0, 99999); // For mobile devices
			navigator.clipboard.writeText(copyText.value);
			toastr.success("Link Coppied");
			//alert("Copied the text: " + copyText.value);
		}))

		$(".variants-check").on('change', (function(e) {
			var n = $(".variants-check").length - 1;
			var product_id = $('input[name="product_id"]').val();
			var variant = '';
			for (var i = 0; i <= n; i++) {
				if (i == n) {
					variant += $($(".variants-check")[i]).val();
				} else {
					variant += $($(".variants-check")[i]).val() + ',';
				}
			}

			$.ajax({
				url: "{{ route('cart.check_variants') }}",
				type: "POST",
				data: {
					'product_id': product_id,
					'variants': variant
				},
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				beforeSend: function() {
					$('.submit_button').hide();
					$('.loading').show();
					$('.stock-out').hide();
				},
				success: function(result) {
					if (result.success) {
						//toastr.success(result.message);
						$('.stock-out').hide();
						$('.submit_button').show();
						$('.loading').hide();
					} else {
						//toastr.error(result.message);
						$('.stock-out').show();
						$('.submit_button').hide();
						$('.loading').hide();
					}
					$('.price-text').html('Rs. ' + result.data.amount);
				},
				error: function(e) {
					console.log(e);
					var e = eval("(" + e.responseText + ")");
					if (e.message == "CSRF token mismatch.") {
						toastr.error('Your session has expired');
						location.reload();
						setTimeout(function() {
							location.reload();
						}, 3000);
					} else {
						toastr.error('Something Wrong');
					}
					$('.stock-out').show();
					$('.submit_button').hide();
					$('.loading').hide();
				}
			});
		}))

		$("#addtocart").on('submit', (function(e) {
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
						$('.shopping-badge').html(result.cart_count);
						$('.gotocart-btn').show();
					} else {
						if (!result.auth) {
							$('#authmodal').modal('show');
						} else {
							toastr.error(result.message);
						}
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e) {
					console.log(e);
					var e = eval("(" + e.responseText + ")");
					if (e.message == "CSRF token mismatch.") {
						toastr.error('Your session has expired');
						location.reload();
						setTimeout(function() {
							location.reload();
						}, 3000);
					} else {
						toastr.error('Something Wrong');
					}
					$('.submit_button').show();
					$('.loading').hide();
				}
			});
		}));

		$(".btn-feverit").on('click', (function(e) {

			$.ajax({
				url: url + '/wishlist/add_remove',
				type: "POST",
				data: {
					'product_id': this.id,
				},
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				beforeSend: function() {},
				success: function(result) {
					//console.log(data);

					if (result.success) {
						toastr.success(result.message);
						if (result.is_fevourit == 1) {
							$(".btn-feverit").addClass('fev-active');
						} else {
							$(".btn-feverit").removeClass('fev-active');
						}
						$('.hart-badge').html(result.wishlist_count);
					} else {
						if (!result.auth) {
							$('#authmodal').modal('show');
						} else {
							toastr.error(result.message);
						}
					}
				},
				error: function(e) {
					console.log(e);
					var e = eval("(" + e.responseText + ")");
					if (e.message == "CSRF token mismatch.") {
						toastr.error('Your session has expired');
						location.reload();
						setTimeout(function() {
							location.reload();
						}, 3000);
					} else {
						toastr.error('Something Wrong');
					}
				}
			});
		}));
	});



	//reviews
	$("#review_form").on('submit', (function(e) {
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

					//load review
					offset = 0;
					$('#review-list').html('');
					load_review_data();
				} else {
					if (!result.auth) {
						$('#authmodal').modal('show');
					} else {
						toastr.error(result.message);
					}
				}
				$('.submit_button').show();
				$('.loading').hide();
			},
			error: function(e) {
				console.log(e);
				var e = eval("(" + e.responseText + ")");
				if (e.message == "CSRF token mismatch.") {
					toastr.error('Your session has expired');
					location.reload();
					setTimeout(function() {
						location.reload();
					}, 3000);
				} else {
					toastr.error('Something Wrong');
				}
				$('.submit_button').show();
				$('.loading').hide();
			}
		});
	}));

	$('.load-more-btn').click(function() {
		load_more = true;
		load_review_data();
	});
	var offset = 0;
	var limite = 4;
	var load_more = false;

	function load_review_data() {
		$.ajax({
			url: url + '/products/get_product_review',
			type: "POST",
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			data: {
				'offset': offset,
				'limite': limite,
				'id': '{{ $product->id }}',
			},
			dataType: "json",
			beforeSend: function() {
				$('.load-more-btn').hide();
				$('.loading-btn').show();
			},
			success: function(result) {
				if (result.success) {
					$('.loading-btn').hide();

					console.log(result.record);;
					$('#review-list').append(result.data);

					offset += limite;

					//show load more btn
					if (offset < result.record) {
						$('.load-more-btn').show();
					}

					load_more = false;
				} else {
					toastr.error(result.message);
				}
			},
			error: function(e) {
				console.log(e);
				var e = eval("(" + e.responseText + ")");
				if (e.message == "CSRF token mismatch.") {
					toastr.error('Your session has expired');
					location.reload();
					setTimeout(function() {
						location.reload();
					}, 3000);
				} else {
					toastr.error('Something Wrong');
				}
			}
		});
	}

	load_review_data();
</script>

<!-- image Zooming -->
<script type="text/javascript">
	(function() {

		if (typeof $ !== "function")
			throw Error('JQuery is not present.');

		var times = 2,
			handler;

		var init = function() {

			var t = $(this),
				p = t.parent(),
				v = p.next(),
				cs = v.next(),
				iw = v.children();

			handler = function(e) {

				var [w, h] = ['width', 'height'].map(x => $.fn[x].call(t)),
					nw = w * times, nh = h * times, cw = w / times, ch = h / times;

				var eventMap = {
					mousemove: function(e) {

						e = e.originalEvent;

						var x = e.layerX,
							y = e.layerY,
							rx = cw / 2,
							ry = ch / 2,
							cx = x - rx,
							cy = y - ry,
							canY = cy >= 0 && cy <= h - ch,
							canX = cx >= 0 && cx <= w - cw

						cs.css({
							top: canY ? cy : cy < 0 ? 0 : h - ch,
							left: canX ? cx : cx < 0 ? 0 : w - cw
						});

						iw.css({
							top: canY ? -cy / (h - ch) * (nh - h) : cy < 0 ? 0 : -(nh - h),
							left: canX ? -cx / (w - cw) * (nw - w) : cx < 0 ? 0 : -(nw - w)
						});
					}
				};

				p.width(w).height(h);
				cs.width(cw).height(ch);
				iw.width(nw).height(nh);

				for (let k in eventMap)
					p.on(k, eventMap[k]);
			};

			t.on('load', handler);
		};

		$.fn.extend({

			zoom: function(t) {
				times = t || times;

				for (let x of this)
					init.call(x);

				return this;
			},
			setZoom: function(t) {

				times = t || times;

				if (handler === void 0)
					throw Error('Zoom not initialized.');

				handler();

			}

		});

	}());
</script>
<script type="text/javascript">
	var l = $('#target').zoom(2);

	$('input[type="range"]').on('change', function() {

		l.setZoom(this.value);

	});
</script>
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-36251023-1']);
	_gaq.push(['_setDomainName', 'jqueryscript.net']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	})();
</script>

@endsection