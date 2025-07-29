@extends('front.layouts.index')

@section('seo')

@php
$description = 'Bajarang';
$keywords = 'Bajarang';
@endphp

<title>Bajarang | Cart</title>


@endsection

@section('custom_css')

<style>
	.cart-qty {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.cart-qty .qty-minus,
	.cart-qty .qty-plus {
		background: var(--secondary);
		padding: 8px 9px;
		border-radius: 100%;
		cursor: grab;
	}

	.cart-qty span {
		margin: 0px 4px;
	}


	.cart-qty span input {
		width: 10%;
		text-align: center;
		border: unset;
	}

	.cart-empty-img {
		height: 250px;
		width: -webkit-fill-available;
		object-fit: contain;
	}

	.cat-p-img {
		height: 100px;
		width: 100px;
		object-fit: contain;
		background: #F8F8F8;
		padding: 8px;
		border-radius: 6px;
		margin-right: 6px;
	}

	.summary {
		background: var(--secondary);
		border-radius: 5px;
	}

	.table1 {
		width: 100%;
		background: var(--secondary);
	}

	.table1 td {
		padding: 7px 7px;
	}

	.table1 .end {
		border-bottom: 3px solid #9A9A9A;
	}
</style>

@endsection

@section('content')

<section id="nevigation-header">
	<h3>Add To Cart</h3>
	<p>Home <i class="fa-solid fa-angle-right"></i> Add To Cart</p>
</section>

<section id="about" class="mt-5 mb-5 pb-5">
	<div class="container" style="overflow: auto;">

		@if(isset($carts) && !empty($carts) && count($carts) > 0)
		<p class="h4 font-wieght-bold mb-3"> Your Cart Items</p>
		<table class="table mb-0">
			<tr>
				<th style="border-top: unset;">Item Name</th>
				<th class="text-center" style="border-top: unset;">Price</th>
				<th class="text-center" style="border-top: unset;">Quantity</th>
				<th class="text-center" style="border-top: unset;">Total</th>
				<th style="border-top: unset;"></th>
			</tr>
			@foreach($carts as $val)
			<tr id="tr{{ $val->id }}">
				<td width="40%">
					<span class="float-left mr-2">
						<img class="cat-p-img" src="{{ $val->image }}" />
					</span>
					<p>
						{{ (isset($val->product_data) && !empty($val->product_data->name))? $val->product_data->name :'' }}
						@if(isset($val->v_data) && count($val->v_data) > 0)
						<br>
						(
						@php $c = 1; @endphp
						@foreach($val->v_data as $key=>$vals)
						@if(count($val->v_data) != $c) {{ $key.' : '.$vals.',' }} @else {{ $key.':'.$vals }} @endif
						@php $c++; @endphp
						@endforeach
						)
						@endif
					</p>
				</td>
				<td class="text-center">Rs. {{ $val->amount }}</td>
				<td class="text-center">
					<div class="cart-qty">
						<span><i class="fa-solid fa-minus qty-minus" data-cartid="{{ $val->id }}" data-price="{{ $val->amount }}"></i></span>
						<span class="d-qyt{{ $val->id }}">{{ $val->quantity }}</span>
						<span><i class="fa-solid fa-plus qty-plus" data-cartid="{{ $val->id }}" data-price="{{ $val->amount }}"></i></span>
					</div>
					<input type="hidden" id="input-qty{{ $val->id }}" value="{{ $val->quantity }}" />
				<td class="text-center totals{{ $val->id }}">Rs. {{ $val->amount * $val->quantity }}</td>
				<td><i class="fa-regular fa-circle-xmark text-primary h4" onclick="remove_cart({{ $val->id }})"></i></td>
			</tr>
			@endforeach
		</table>

		<div class="row">
			<div class="col-md-6 col-6 mb-4">
				<a class="btn btn-primary btn-round" href="{{ url('/products') }}" alt="Go To Shop"> GO TO SHOP </a>
			</div>
			<div class="col-md-6 col-6 text-right mb-4">
				<button class="btn btn-primary-line btn-round" title="Clear Cart" onclick="remove_cart(1,1)"> Clear all </button>
			</div>
			<div class="col-md-8 col-0">
			</div>
			<div class="col-md-4 col-12 p-3 summary">

				<table class="table1">
					<tr>
						<td><b>SubTotal :</b></td>
						<td></td>
						<td class="text-right">Rs. {{ $summary['subtotle'] }}</td>
					</tr>
					<tr>
						<td><b>Discount :</b></td>
						<td></td>
						<td class="text-right">Rs. {{ $summary['discount'] }}</td>
					</tr>
					<tr class="end">
						<td><b>Tax :</b></td>
						<td></td>
						<td class="text-right">Rs. {{ $summary['tax'] }}</td>
					</tr>
					<tr>
						<td><b>Total :</b></td>
						<td></td>
						<td class="text-right">Rs. {{ $summary['totle'] }}</td>
					</tr>
				</table>

				<div class="text-center">
					@if(Auth::check())
					<a class="btn btn-primary btn-block btn-sm btn-round mt-3" href="{{ route('ckeckout') }}"> PROCEED TO CHECKOUT </a>
					@else
					<a class="btn btn-primary btn-block btn-sm btn-round mt-3" href="#" data-toggle="modal" data-target="#authmodal"> PROCEED TO CHECKOUT </a>

					@endif
				</div>

			</div>
		</div>


		@else
		<div class="text-center">
			<img class="cart-empty-img" src="{{ asset('front/images/empty-cart.png') }}" />

			<p class="h4 font-wieght-bold mt-5"> Your cart is empty</p>
			<p>Looks like you have not added anything to your cart. Go ahead & explore top categories.</p>
			<a class="btn btn-primary btn-round pr-3 pl-3 mt-3" href="{{ route('Products') }}"> Return To Shop </a>
		</div>
		@endif

	</div>
</section>

@endsection

@section('custom_js')
<script>
	// cart qty script
	$('.qty-plus').click(function() {
		var id = $(this).data('cartid');
		var input_qty = $('#input-qty' + id).val();
		input_qty++;
		update_cart(id, input_qty);

	});
	$('.qty-minus').click(function() {
		var id = $(this).data('cartid');
		var input_qty = $('#input-qty' + id).val();
		if (input_qty > 1) {
			input_qty--;
			update_cart(id, input_qty);
		}
	});

	function update_cart(cart_id, qty) {
		$.ajax({
			url: "{{ route('cart.update_cart') }}",
			type: "POST",
			data: {
				'cart_id': cart_id,
				'quantity': qty,
			},
			dataType: "json",
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			beforeSend: function() {

			},
			success: function(result) {
				//console.log(data);

				if (result.success) {
					toastr.success(result.message);
					location.reload();
				} else {
					if (result.auth == false) {
						location.reload();
					} else {
						toastr.error(result.message);
					}
					if (result.delete == true) {
						setTimeout(function() {
							location.reload();
						}, 3000);
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
	}

	function remove_cart(cart_id, all = 0) {
		$.ajax({
			url: "{{ route('cart.remove_from_cart') }}",
			type: "POST",
			data: {
				'cart_id': cart_id,
				'delete_all': all,
			},
			dataType: "json",
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			beforeSend: function() {

			},
			success: function(result) {
				//console.log(data);

				if (result.success) {
					toastr.success(result.message);
					location.reload();
				} else {
					if (result.auth == false) {
						location.reload();
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
	}
</script>

@endsection