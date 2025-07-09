@extends('front.layouts.index', ['seo' => [
'title' => 'Collections',
'description' => 'Collections',
'keywords' => 'Collections' ,
'image' => config('const.site_setting.logo') ,
'city' => '',
'state' => '',
'position' => ''
]
])

@section('seo')

@section('content')

<section id="nevigation-header">
	<h3>Collections</h3>
	<p>Home <i class="fa-solid fa-angle-right"></i> Collections</p>
</section>

@if( isset($Category) && !empty($Category) && count($Category) > 0 )
@foreach($Category as $cat)
@if( isset($cat->collection_data) && !empty($cat->collection_data) && count($cat->collection_data) > 0 )
<section id="collection" class="mt-5 mb-5 ">
	<div class="container section-border p-5">
		<div class="row mb-5">
			<div class="col-lg-8 col-md-8 col-12 header-contaimer">
				<h4 class="font-weight-bold">{{ strtoupper($cat->name) }}</h4>
				<p>Showing our latest arrival on this summer</p>
			</div>
			<div class="col-lg-4 col-md-4 col-12 header-contaimer text-right align-self-end">
				<a href="{{ route('collections', $cat->slug ) }}" class="btn btn-primary btn-sm btn-round px-4">View All</a>
			</div>

			@foreach($cat->collection_data as $val)
			<a href="{{ url('/products/'.$val->slug) }}" class="col-lg-3 col-md-3 col-12 mt-4 pos">
				<div class="new-product">
					<div class="product-img">
						@if (isset($val->images_data) && count($val->images_data) > 0)
						<img loading="lazy" class="product__single" src="{{ getImage(isset($val->images_data[0])?$val->images_data[0]->image:'') }}" alt="{{ $val->name }}">
						@if (isset($val->images_data[1]))
						<img loading="lazy" class="secondary-img" src="{{ getImage($val->images_data[1]->image) }}" alt="{{ $val->name }}">
						@endif
						@endif
					</div>
					<div class="product-info text-center">
						<!--  
<div class="row mt-2 pb-0">
							<div class="col-sm-12  col-12">
								<div class="d-flex mt-2 justify-content-center">
									<p class="badges bg-danger"></p>
									<p class="badges bg-success"></p>
									<p class="badges bg-warning"></p>
								</div>
							</div>
						</div>
 -->
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
	</div>
</section>
@endif
@endforeach
@endif





@endsection