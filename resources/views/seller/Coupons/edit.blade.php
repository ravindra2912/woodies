@extends('seller.layouts.index')

@section('custom_css')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin_theme/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin_theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<style>
	.head_label {
		font-weight: 900;
		font-size: 20px;
		border-bottom: 1px solid #787272;
		width: 100%;
		padding-bottom: 7px;
		margin-bottom: 12px;
	}
</style>
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header bg-primary">
					<h3 class="card-title">Update Coupon</h3>
				</div>
				<div class="card-body row">
					<input type="hidden" id="form_url" value="{{ route('coupons.updates',$Coupons->id) }}">
					<input type="hidden" id="add_product_form_url" value="{{ route('coupons.add_product') }}">
					<input type="hidden" id="remove_product_form_url" value="{{ route('coupons.remove_product') }}">
					<input type="hidden" id="coupon_id" value="{{ $Coupons->id }}">
					<div class="col-md-4 col-sm-6 row">
						<div class="form-group col-md-12 col-sm-12">
							<label class="required">Coupon Code</label>
							<input type="text" class="form-control" value="{{$Coupons->coupon_code}}" name="coupon_code" id="coupon_code" onchange="Check_code()" placeholder="Enter Coupon Code">
						</div>
					</div>

					<div class="form-group col-md-4 col-sm-6">
						<label class="required">Select Coupon Type</label>
						<select class="form-control" name="type" id="type" onchange="check_type(this.value)" required>
							<option value="">Please Select Coupon Type</option>
							<option value="1" @if( $Coupons->coupon_type == 1) selected @endif>Percentage</option>
							<option value="2" @if( $Coupons->coupon_type == 2) selected @endif>Free amount</option>
							<!-- option value="3" @if( $Coupons->coupon_type == 3) selected @endif>Free shipping</option -->
						</select>
					</div>

					<div class="form-group col-md-4 col-sm-6" id="for_amt_per" style=" @if( $Coupons->coupon_type == 3 ||  $Coupons->coupon_type == null) display:none; @endif ">
						<div id="type_coupon_amount" style="@if( $Coupons->coupon_type == 1) display:none; @endif">
							<label class="form-label">Amount</label>
							<input class="form-control" name="coupon_amount" value="{{ $Coupons->coupon_amount }}" id="coupon_amount" type="number" placeholder="Enter amount">
						</div>
						<div id="type_coupon_percent" style="@if( $Coupons->coupon_type == 2) display:none; @endif">
							<label class="form-label">Percentage</label>
							<input class="form-control" name="coupon_percent" value="{{ $Coupons->coupon_percent }}" max="100" min="1" id="coupon_percent" type="number" placeholder="Enter Percentage">
						</div>
					</div>

					<div class="form-group col-md-4 col-sm-6">
						<label class="required">Active date</label>
						<input class="form-control " name="active_date" value="{{ $Coupons->active_date }}" type="date">
					</div>

					<div class="form-group col-md-4 col-sm-6">
						<label class="required">End date</label>
						<input class="form-control" name="end_date" type="date" value="{{ $Coupons->end_date }}">
					</div>

					<div class="form-group col-md-4 col-sm-6">
						<label class="required">Status</label>
						<select class="form-control" name="status" id="status">
							<option value="Active" @if($Coupons->status == 'Active') selected @endif>Active</option>
							<option value="InActiv" @if($Coupons->status == 'InActiv') selected @endif>In-Active</option>
						</select>
					</div>

					<div class="form-group col-md-12 col-sm-12">
						<button class="btn btn-primary submit_button" for="coupon_form" style="margin-top: 20px;" type="button">Save</button>
					</div>

				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header bg-primary">
					<h3 class="card-title">Products</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-md-3 col-sm-6">
							<label class="required">Select Category</label>
							<select class="form-control" name="category" id="category" required>
								<option value="">Please Select Category</option>
								@if(isset($categoryData) && !empty($categoryData))
								@foreach($categoryData as $data)
								<option value="{{ $data->id }}">{{ ucwords($data->name) }}</option>
								@endforeach
								@endif
							</select>
						</div>

						<div class="form-group col-md-3 col-sm-6">
							<label class="required">Product</label>
							<select class="select2" multiple="multiple" data-placeholder="Please Select Products" name="product_id" id="products" style="width: 100%;">
							</select>
						</div>
						<div class="form-group col-md-6 col-sm-12 align-self-end ">
							<button class="btn btn-primary add_product_submit_button" type="button">Add</button>
						</div>
					</div>

					<table id="example1" class="table table-bordered table-striped w-100">
						<thead>
							<tr>
								<th>Sr. No</th>
								<th>Product Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@php $i=1; @endphp
							@if(isset($discounted_products) && !empty($discounted_products))
							@foreach($discounted_products as $val)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $val->name }}</td>
								<td>
									<div class="d-flex">
										<button class="btn btn-danger tableActionBtn " onclick="remove_product({{ $val->id }})" title="Delete Product"><i class="right fas fa-trash"></i></button>
									</div>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>


				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('custom_js')

<!-- Select2 -->
<script src="{{ asset('admin_theme/plugins/select2/js/select2.full.min.js') }}"></script>


<script>
	// generate code	
	function generate_code() {
		var length = 6;
		var result = '';
		var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		var charactersLength = characters.length;
		for (var i = 0; i < length; i++) {
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
		}

		$('#coupon_code').val(result);
		Check_code();
	}
	// to check code is not repeated
	function Check_code() {
		var coupon_code = $('#coupon_code').val();
	}

	// to check type 
	function check_type(type) {
		//var type =  $("input:radio[name=type]: checked ").val();
		if (type == 3) {
			$('#for_amt_per').hide();

		} else {
			$('#for_amt_per').show();

			if (type == 1) {
				$('#type_coupon_percent').show();
				$('#type_coupon_amount').hide();

			} else if (type == 2) {
				$('#type_coupon_percent').hide();
				$('#type_coupon_amount').show();
			} else {
				$('#type_coupon_percent').hide();
				$('#type_coupon_amount').hide();
				$('#for_amt_per').hide();
			}
		}
	}

	//to check minimum require
	function check_mini_req(mini_reqpe) {
		//var mini_reqpe =  $("input:radio[name=minimum_requrment_type]: checked ").val();

		if (mini_reqpe == 0) {
			$('#minimum_requrment_amt').hide();
			$('#minimum_requrment_qty').hide();
		} else if (mini_reqpe == 2) {
			$('#minimum_requrment_amt').hide();
			$('#minimum_requrment_qty').show();
		} else if (mini_reqpe == 1) {
			$('#minimum_requrment_amt').show();
			$('#minimum_requrment_qty').hide();
		}

	}

	function usage_limit_show(usage_type) {
		//var usage_type =  $("input:checkbox[name=usage_limit_type]: checked ").val();
		if (usage_type) {
			$('#usage_limit').show();
		} else {
			$('#usage_limit').hide();
		}
	}
</script>

<script type="text/javascript">
	$("document").ready(function() {
		$(".submit_button").click(function() {

			var coupon_code = $("input[name=coupon_code]").val();
			var type = $("#type").val();

			var coupon_amount = $("input[name=coupon_amount]").val();
			var coupon_percent = $("input[name=coupon_percent]").val();

			var active_date = $("input[name=active_date]").val();

			var end_date = $("input[name=end_date]").val();

			var status = $("#status").val();



			var fd = new FormData();
			fd.append("coupon_code", coupon_code ? coupon_code : '');
			fd.append("type", type ? type : '');
			fd.append("coupon_amount", coupon_amount ? coupon_amount : '');
			fd.append("coupon_percent", coupon_percent ? coupon_percent : '');
			fd.append("active_date", active_date ? active_date : null);
			fd.append("end_date", end_date ? end_date : '');
			fd.append("status", status ? status : '');



			$.ajax({
				type: "post",
				url: $("body").find("#form_url").val(),
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				data: fd,
				cache: false,
				contentType: false,
				processData: false,
				success: function(result) {
					if (result.success) {
						toastr.success(result.message);
						setTimeout(function() {
							window.location.href = window.location.origin + '/seller/coupons'
						}, 1000);
					} else {
						toastr.error(result.message);
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
		});


		$(".add_product_submit_button").click(function() {

			var product_id = $("#products").val();
			var coupon_id = $("#coupon_id").val();

			var fd = new FormData();
			fd.append("product_id", product_id ? product_id : '');
			fd.append("coupon_id", coupon_id ? coupon_id : '');

			$.ajax({
				type: "post",
				url: $("body").find("#add_product_form_url").val(),
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				data: fd,
				cache: false,
				contentType: false,
				processData: false,
				success: function(result) {
					if (result.success) {
						toastr.success(result.message);
						location.reload();
					} else {
						toastr.error(result.message);
					}
				},
				error: function(error) {
					console.log(error);
				}
			});

		});

	});

	$("#category").change(function() {

		var category = $("#category").val();

		var fd = new FormData();
		fd.append("category", category ? category : '');

		var url = "{{ route('get_product_by_category') }}";

		$.ajax({
			type: "post",
			url: url,
			dataType: "json",
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			data: fd,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result) {
				if (result.success) {
					var html = "";
					if (result.data.length > 0) {
						html += "<option value='' disabled>Please Select Products</option>";
						for (var i = 0; i < result.data.length; i++) {
							html += "<option value='" + result.data[i].id + "'>" + result.data[i].name + "</option>";
						}
						$("#products").html(html);
					}

				} else {
					toastr.error(result.message);
				}
			}
		});
	});

	function remove_product(product_id) {
		var coupon_id = $("#coupon_id").val();

		var fd = new FormData();
		fd.append("product_id", product_id ? product_id : '');
		fd.append("coupon_id", coupon_id ? coupon_id : '');

		Swal.fire({
				title: 'Are you sure?',
				icon: 'error',
				html: "Want To Remove This Product?",
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonText: 'Delete',
				cancelButtonText: 'Cancel',
			})
			.then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: "post",
						url: $("body").find("#remove_product_form_url").val(),
						dataType: "json",
						headers: {
							'X-CSRF-TOKEN': "{{ csrf_token() }}"
						},
						data: fd,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result) {
							if (result.success) {
								toastr.success(result.message);
								location.reload();
							} else {
								toastr.error(result.message);
							}
						},
						error: function(error) {
							console.log(error);
						}
					});
				}
			});
	}

	$(function() {
		//Initialize Select2 Elements
		$('.select2').select2()
	});
</script>
@endsection