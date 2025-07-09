	@foreach($productLists as $val)
	<a href="{{ url('/products/'.$val->slug) }}" class="col-lg-3 col-md-3 col-6 mt-3 pos p-0">
		<!-- <a href="{{ url('/products/'.$val->slug) }}" class="col-lg-4 col-md-4 col-6 mt-3 pos"> -->
		<div class="new-product">
			<div class="product-img">
				<img loading="lazy" class="product__single" src="{{ getImage(isset($val->images_data[0])?$val->images_data[0]->image:'') }}" alt="{{ $val->name }}">
				<img loading="lazy" class="secondary-img" src="{{ getImage(isset($val->images_data[1]) ? $val->images_data[1]->image:'') }}" alt="{{ $val->name }}">
			</div>
			<div class="product-info text-center">
				<!-- <div class="row mt-2 pb-0">
					<div class="col-sm-12 col-12">
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