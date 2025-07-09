@extends('front.layouts.index', ['seo' => [
'title' => $Category->name,
'description' => $Category->SEO_description,
'keywords' => $Category->SEO_tags ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])


@php
		$banner_img = (isset($Category->banner_img) && file_exists($Category->banner_img))? asset($Category->banner_img) :'';
	@endphp

@section('custom_css')

	<style>
		.sort-select{
			border: unset;
			font-size: 20px;
			font-weight: 900;
		}
		.cat-banner{
			object-fit: contain;
			width: -webkit-fill-available;
			height: 700px;
			position: relative;
		}
		
		.ph{
			overflow-y: auto;
			height: 1000px;
		}
		
		.cat-title{
			background: rgba(220, 53, 69, 0.6);
			width: fit-content;
			border-radius: 100%;
			padding: 40px 20px;
			text-align: center;
			color: white;
		}
		
		.cat-title p{
			font-style: normal;
			font-weight: 700;
			font-size: 35px;
			text-align: center;
			text-transform: capitalize;
			color: #FFFFFF;
			margin-bottom: 0px;
		}
		<?php if(isset($banner_img) && !empty($banner_img)){ ?>
			/* product setting */
			.new-product .product-img img, .new-product .product-img .secondary-img {
				height: 200px;
			}
			.new-product .product-info .product-description {
				-webkit-line-clamp: 2;
				height: auto;
			}
		<?php } ?>
	</style>	
@endsection

@section('content')

	<section id="nevigation-header">
		@if($Category->level != 0)
			<h3>{{ strtoupper($Category->name) }} Collection</h3>
			<p>Home <i class="fa-solid fa-angle-right"></i> Collection <i class="fa-solid fa-angle-right"></i> {{ strtoupper($Category->name) }} Collection</p>
		@else
			<h3>{{ strtoupper($Category->name) }}</h3>
			<p>Home <i class="fa-solid fa-angle-right"></i> {{ strtoupper($Category->name) }}</p>
		@endif
	</section>
	
	
  
	<section id="collection" class="mt-5 mb-5 pb-5">
		<div class="container">
			<div class="row mb-5">
				@if(isset($banner_img) && !empty($banner_img))
					<div class="col-lg-6 col-md-6 col-12">
						<div class="cat-title">
							<p>{{ strtoupper($Category->name) }}</p>
							<p>PRODUCTS</p>
						</div>
						<img loading="lazy"  class="cat-banner" id="cat-banner-img" src="{{ $banner_img }}" alt="{{ strtoupper($Category->name) }}">
					</div>
				@endif
				
				@if(isset($banner_img) && !empty($banner_img))
					<div class="col-lg-6 col-md-6 col-12 row ph">
				@else
					<div class="col-lg-12 col-md-12 col-12 row">
				@endif
				@foreach($productLists as $val)
					@if(isset($banner_img) && !empty($banner_img))
						<a href="{{ url('/products/'.$val->slug) }}" class="col-lg-6 col-md-6 col-12 mt-4 pos">
					@else
						<a href="{{ url('/products/'.$val->slug) }}" class="col-lg-3 col-md-3 col-12 mt-4 pos">
					@endif
						<div class="new-product">
						  <div class="product-img">
						  <img loading="lazy" class="product__single" src="{{ getImage(isset($val->images_data[0])?$val->images_data[0]->image:'') }}" alt="{{ $val->name }}">
						@if (isset($val->images_data[1]))
						<img loading="lazy" class="secondary-img" src="{{ getImage($val->images_data[1]->image) }}" alt="{{ $val->name }}">
						@endif
						  </div>
							<div class="product-info text-center">
								<!-- div class="row mt-2 pb-0" >
									<div class="col-sm-12  col-12" >
										<div class="d-flex mt-2 justify-content-center">
											<p class="badges bg-danger"></p>
											<p class="badges bg-success"></p>
											<p class="badges bg-warning"></p>
										</div>
									</div>
								</div -->
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
			
			
		</div>
	</section>
	
	
  
	<script>
		$(document).ready(function($){
            $("#collection").mousemove(function(e){
                var mouseX = e.pageX - $('#collection').offset().left;
                var mouseY = e.pageY - $('#collection').offset().top;
                var totalX = $('#collection').width();
                var totalY = $('#collection').height();
                var centerX = totalX / 2;
                var centerY = totalY / 2;
                var shiftX = centerX - mouseX;
                var shiftY = centerY - mouseY;

                var startX = ($('#collection').width() / 2) - ($('#cat-banner-img').width() / 2);
                var startY = ($('#collection').height() / 2) - ($('#cat-banner-img').height() / 2);

                $('#cat-banner-img').css('z-index') ;
               // $('#cat-banner-img').css({ 'left': startX + (shiftX/10) + 'px', 'top': startY + (shiftY/10) + 'px' });
                $('#cat-banner-img').css({ 'left': (shiftX/30) + 'px', 'top': (shiftY/30) + 'px' });
            });
        });
	</script>

@endsection



