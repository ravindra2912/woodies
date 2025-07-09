@extends('front.layouts.index')

@section('seo')
		<title>Bajarang | Wishlist</title>
@endsection

@section('custom_css')  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
	
	.p-img{
		background: #F8F8F8;
		padding: 10px;
		height: 100px;
	}
	
	.table td, .table th {
		border-bottom: 2px solid #9A9A9A;
		border-top: unset;
	}
</style>

@endsection

@section('content')

	<section id="nevigation-header">
		<h3>Wishlist</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Wishlist</p>
	</section>
  
	<section class="mt-5 mb-5 pb-5">
		<div class="container" style="overflow: auto;">
			<h4 class="font-weight-bold mb-5">Your Wishlist Items</h4>
			@if(isset($Wishlist_data) && !empty($Wishlist_data) && count($Wishlist_data) > 0)
				<table class="table" >
					<tr>
					
						<th colspan="2">Item Name</th>
						<th>Price</th>
						<th>Availability</th>
						<th></th>
						<th></th>
					</tr>
					@foreach($Wishlist_data as $val)
					<tr>
						<td width="10%"><img class="p-img" src="{{ $val->image }}" /></td>
						<td width="30%" class="text-left">{{ $val->name }}</td>
						<td style="color: #7D7D7D;">Rs. {{ $val->price }}</td>
						<td class="{{ ($val->stock == 'In Stock')? 'text-success' : 'text-primary' }}">{{ $val->stock }}</td>
						<td>
							@if($val->in_cart == 1)
								<a href="{{ url('/cart') }}" class="btn btn-primary btn-round px-4">
									<i class="fa-solid fa-cart-shopping"></i>
								</a>
							@else
								<a href="{{ url('/products/'.$val->slug) }}" class="btn btn-primary btn-round">
									ADD TO CART
								</a>
							@endif
						</td>
						<td>
							<span class="h2 ml-4 btn-feverit" style="color: #7D7D7D;" id="{{ $val->id }}"><i class="fa-regular fa-circle-xmark mt-2"></i></span>
						</td>
					</tr>
					@endforeach
				</table>
				<div class="d-flax " >
					{{ $Wishlist_data->appends(request()->except('page'))->links() }}
				</div>
				
			@else
				<div class="text-center">
				
					<p class="h4 font-wieght-bold mt-5" > Your Wishlist is empty</p>
				</div>
			@endif
			
			
		</div>
	</section>
	
@endsection

@section('custom_js')  
<script>	

	$(".btn-feverit").click(function(){
		Swal.fire({
			title: 'Are you sure?',
			icon: 'error',
			html: "You want to Remove this Product?",
			allowOutsideClick: false,
			showCancelButton: true,
			confirmButtonText: 'Delete',
			cancelButtonText: 'Cancel',
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: url+'/wishlist/add_remove',
					type: "POST",
					data:  {
						'product_id': this.id,
					},
					dataType: "json",
					headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
					beforeSend : function(){ 
					},
					success: function(result){
						//console.log(data);
						if(result.success){
						  toastr.success(result.message);
							location.reload();
						}
						else{
							if(auth == false){
								location.reload();
							}else{
								toastr.error(result.message);
							}
							
						}
					},
					error: function(e){ 
						toastr.error('Something Wrong');
						console.log(e);
					}           
				});
			}
		})
	});

	
</script>	

@endsection

