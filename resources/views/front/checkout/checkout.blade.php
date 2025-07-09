@extends('front.layouts.index')

@section('seo')

@php
$description = 'Bajarang';
$keywords = 'Bajarang';
@endphp

<title>Bajarang | CheckOut</title>


@endsection

@section('custom_css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
	.divider {
		border-bottom: 2px solid #9A9A9A;
	}

	.p-img {
		height: 50px;
		width: auto;
		object-fit: contain;
	}

	.address {
		border: 2px solid #9A9A9A;
		border-radius: 10px;
		padding: 8px 10px;
		position: relative;
	}

	.address:hover,
	input[name="selectaddress"]:checked+label .address {
		border: 2px solid var(--primary);
		box-shadow: 0 .1rem 0.5rem var(--primary) !important;
	}

	input[name="selectaddress"] {
		opacity: 0;
		//position: absolute;
		//top: 324px;
	}


	.coupon-btn {
		border-bottom-left-radius: 0;
		border-top-left-radius: 0;
	}
</style>

@endsection

@section('content')

<section id="nevigation-header">
	<h3>CheckOut</h3>
	<p>Home <i class="fa-solid fa-angle-right"></i> Cart <i class="fa-solid fa-angle-right"></i>CheckOut</p>
</section>

<section id="about" class="mt-5 mb-5 pb-5">
	<div class="container">

		<form id="placeorder" class="row" action="{{ route('order.place_order') }}">
			<div class="col-sm-7">
				<div class="row">
					<div class="col-lg-12 col-sm-12">
						<div action="" class="row">

							<div class="form-group col-lg-12 col-md-12 col-12 mt-4">
								<h5 class="mt-2 font-weight-bold">Shipping Address</h5>
							</div>
							<div class="form-group col-lg-6 col-md-6 col-12">
								<input type="text" name="name" class="form-control" placeholder="Your Name *" required>
							</div>

							<div class="form-group col-lg-6 col-md-6 col-12">
								<input type="number" name="contact" class="form-control" placeholder="Your Contact Number *" required>
							</div>

							<div class="form-group col-lg-12 col-md-12 col-12">
								<input type="text" name="address" class="form-control" placeholder="Your address *" required>
							</div>

							<div class="form-group col-lg-12 col-md-12 col-12">
								<input type="text" name="address2" class="form-control" placeholder="Your address 2 *" required>
							</div>

							<div class="form-group col-lg-6 col-md-6 col-12">
								<input type="text" name="country" class="form-control" placeholder="Your Country *" required>
							</div>

							<div class="form-group col-lg-6 col-md-6 col-12">
								<input type="text" name="state" class="form-control" placeholder="Your State *" required>
							</div>

							<div class="form-group col-lg-6 col-md-6 col-12">
								<input type="text" name="city" class="form-control" placeholder="Your City *" required>
							</div>

							<div class="form-group col-lg-6 col-md-6 col-12">
								<input type="text" name="zipcode" class="form-control" placeholder="Your ZipCode *" required>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="col-sm-5">
				<div class="checkout pt-0" id="summary"></div>
		</form>
	</div>
	</form>

	</div>
</section>



@endsection

@section('custom_js')
<script>
	$("document").ready(function() {

		

		$("#placeorder").on('submit', (function(e) {
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
					//console.log(result);

					if (result.success) {
						toastr.success(result.message);
						window.location.href = result.redirect;
						//location.reload();
					} else {
						if (result.auth == false) {
							location.reload();
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
	});

	function get_summary() {
		$.ajax({
			url: "{{ route('ckeckout.render_summary') }}",
			type: "POST",
			data: {
				"address": ($('input[name="address"]').val() != 'undefined') ? $('input[name="address"]').val() : '',
				"coupan_code": ($('#coupan_code').val() != 'undefined') ? $('#coupan_code').val() : '',
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
					$('#summary').html(result.data);
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
	get_summary();
</script>

@endsection