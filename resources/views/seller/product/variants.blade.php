@extends('seller.layouts.index')

@section('custom_css')
    <style>
        .right-wrapper{
            background: #fff !important;
            background-color: #fff !important;
        }
        .note-editing-area {
            background: whitesmoke;
        }
    </style>

    <!-- Summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
	
	 <!-- Sweet Alert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
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
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">{{ $productData->name }} Variants</h3>
					</div>
						<div class="card-body ">
						
						
						
							<div class="row g-3" >
								<!-- div class="col-md-12">
									<div class="form-check">
										<div class="checkbox p-0">
											<input class="form-check-input" id="variantCheck" type="checkbox" name="variantCheck" <?php if($productData->product_variants == 1){ echo 'checked'; } ?>>
											<label class="form-check-label" for="variantCheck">Product Variant</label>
										</div>
									</div>
								</div -->
								@if(count($variants) <= 0)
									<form action="{{ url('/seller/insert_product_variant/'. $productData->id)}}" method="post" class="col-md-12"> @csrf
										<div id="product_variant" >
											<button class="btn btn-primary mb-2" id="add_variant"  type="button">Add New</button>
											<button class="btn btn-success mb-2 float-right" type="submit">Add</button>
										</div>
										
										
									</form>
								@else
									<table class="table table-striped">
										<thead>
											<tr>
											  <th class="text-center" scope="col">Variant</th>
											  <th class="text-center" scope="col">Amount</th>
											  <th class="text-center" scope="col">QTY</th>
											  <th class="text-center" scope="col">Update QTY</th>
											  <th class="text-center" scope="col">Alert QTY</th>
											  <th class="text-center" scope="col">Is Available</th>
											  <th class="text-center" scope="col">
												<button class="btn btn-danger b-0" title="Delete All" onclick="delete_all_variant({{ $productData->id }})"  type="button"><i class="right fas fa-trash"></i></button>
												<a class="btn btn-success mb-2 float-right" title="All Log" href="{{ url('/seller/product/logs/'.$productData->id) }}"><i class="right fas fa-clock"></i></a>
											</th>
											</tr>
										</thead>
										<tbody>
											@foreach($variants as $val)
											<tr id="tr-1">
												<td class="text-center" style="padding: .20rem; vertical-align: unset;">
												@php $c = 1; @endphp
													@foreach($val->v_data as $key=>$vals)
														@if(count($val->v_data) != $c) {{ $key.' : '.$vals.',' }} <br> @else {{ $key.':'.$vals }} @endif
														@php $c++; @endphp
													@endforeach
												</td>
												<td class="text-center justify-content-center d-flex" style="padding: .20rem; vertical-align: unset;">
													<input class="form-control" value="{{ $val->amount }}" type="text" onchange="change_amount({{ $val->id }}, this.value)" style="width: auto">
												</td>
												<td class="text-center" style="padding: .20rem; vertical-align: unset;">{{ $val->qty }} </td>
												<td class="text-center " style="padding: .20rem; vertical-align: unset;">
													<div class="justify-content-center d-flex">
														<button class="btn btn-primary b-0 me-1" style="padding:0.375rem 0.75rem;" onclick="update_qty(0, {{$val->id }})" type="button">-</button>
														<input class="form-control" type="number" style="width: 35%;" id="qty{{ $val->id }}">
														<button class="btn btn-primary b-0 ms-1" style="padding:0.375rem 0.75rem;" onclick="update_qty(1, {{ $val->id }})" type="button">+</button>
													</div>
												</td>
												<td class="text-center justify-content-center" style="padding: .20rem; vertical-align: unset;">
													<input class="form-control" value="<?= $val->alert_qty ?>" type="number" style="width: 45%; display: unset;" onchange="change_alert_qty({{ $val->id }}, this.value)">
												</td>
												<td class="text-center justify-content-center" style="padding: .20rem; vertical-align: unset;">
													<input type="checkbox" class="status" id="status{{ $val->id }}" value="{{ $val->id }}" @if($val->status == 1) checked @endif data-bootstrap-switch data-off-color="danger"  data-on-color="success">
												</td>
												<td class="text-center" style="padding: .20rem; vertical-align: unset;">
													<button class="btn btn-danger b-0" title="delete" onclick="delete_variant({{ $val->id }})"  type="button"><i class="right fas fa-trash"></i></button>
													<a class="btn btn-success mb-2 float-right" title="Log" href="{{ url('/seller/product/logs/'.$productData->id.'?product_variant_id='.$val->id) }}"><i class="right fas fa-clock"></i></a>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								@endif
							</div>
							
						</div>
						
				</div>
                    
            </div>
        </section>
    </div>
@endsection

@section('custom_js')
	<!-- Bootstrap Switch -->
<script src="{{ asset('admin_theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script type="text/javascript"> //roduct variants
	
	$( ".status" ).change(function() {
		var status = 0;
		if(this.checked){
			status = 1;
		}
		
		$.ajax({
			type: "POST",
			url: "{{ route('change_variant_status') }}",
			dataType: "json",
			headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
			data:{ product_variant_id:this.value, status:status },
			success: function(result){
				if(result.success){
					toastr.success(result.message);
				}
				else{
					toastr.error(result.message);
				}
			},
			error: function(e){ 
				//alert("Somthing Wrong");
				console.log(e);
			} 
		});
	});
	
	//for open and close variant
	$( "#variantCheck" ).change(function() {
		if($("#variantCheck").prop('checked') == true){
			$('#product_variant').fadeIn("slow");
		}else{
			$('#product_variant').fadeOut("slow");
		}
	});
	
	//for variant low Qty Alert
	function change_alert_qty(product_variant_id, alert_qty){
		$.ajax({
			type: "POST",
			url: "{{ route('change_alert_qty') }}",
			dataType: "json",
			headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
			data:{ product_variant_id:product_variant_id, alert_qty:alert_qty },
			success: function(result){
				if(result.success){
					toastr.success(result.message);
				}
				else{
					toastr.error(result.message);
				}
			},
			error: function(e){ 
				//alert("Somthing Wrong");
				console.log(e);
			} 
		});
	}
	
	//for update qty of variant
	function update_qty(type, product_variant_id){
		var value = $('#qty'+product_variant_id).val();
		if(value > 0){
			$.ajax({
				type: "POST",
				url: "{{ route('change_variant_qty') }}",
				dataType: "json",
				headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
				data:{ product_variant_id:product_variant_id, type:type, value:value },
				success:function(result)
				{ 
					if(result.success){
						toastr.success(result.message);
						location.reload();
					}
					else{
						toastr.error(result.message);
					}
				},
				error: function(e){ 
					//alert("Somthing Wrong");
					//console.log(e);
				} 
			});
		}else{
			toastr.error('Please Enter Valid QTY');
		}
		
	}
	
	//for update amount of variant
	function change_amount(product_variant_id, amount){
		$.ajax({
			type: "POST",
			url: "{{ route('change_variant_amount') }}",
			dataType: "json",
			headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
			data:{ product_variant_id:product_variant_id, amount:amount },
			success: function(result){
				if(result.success){
					toastr.success(result.message);
				}
				else{
					toastr.error(result.message);
				}
			},
			error: function(e){ 
				//alert("Somthing Wrong");
				console.log(e);
			} 
		});
	}
	
	//for delete variant
	function delete_variant(product_variant_id){
		
		Swal.fire({
			title: 'Are you sure?',
			icon: 'error',
			html: "You want to delete this product variant ?",
			allowOutsideClick: false,
			showCancelButton: true,
			confirmButtonText: 'Delete',
			cancelButtonText: 'Cancel',
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "POST",
					url: "{{ route('delete_product_variant') }}",
					dataType: "json", 
					headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
					data:{ product_variant_id:product_variant_id },
					success:function(result)
					{  //console.log(data);
						if(result.success){
							toastr.success(result.message);
							setTimeout(function(){ location.reload(); }, 1000);
						}
						else{
							toastr.error(result.message);
						}
						
					},
					error: function(e){ 
						alert("Somthing Wrong");
						console.log(e);
					} 
				});
			}
		})
	}
	
	//for delete all variant
	function delete_all_variant(product_id){
		Swal.fire({
			title: 'Are you sure?',
			icon: 'error',
			html: "You want to delete this All product variant ?",
			allowOutsideClick: false,
			showCancelButton: true,
			confirmButtonText: 'Delete',
			cancelButtonText: 'Cancel',
		})
		.then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "POST",
					url: "{{ route('delete_all_product_variant') }}",
					dataType: "json", 
					headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
					data:{ product_id:product_id },
					success:function(result)
					{  //console.log(data);
						if(result.success){
							toastr.success(result.message);
							setTimeout(function(){ location.reload(); }, 1000);
						}
						else{
							toastr.error(result.message);
						}
						
					},
					error: function(e){ 
						alert("Somthing Wrong");
						console.log(e);
					} 
				});
			}
		})
	}
	
	//for add new veriant
	$( "#add_variant" ).click(function() {
		const uid = Date.now();
		var upends = '';
		upends += ' <div class="row mb-2" id="'+uid+'">';
		upends += '		<div class="col-md-4">';
		upends += '			<label class="form-label" >Variant Name</label>';
		upends += '			<input class="form-control" name="variant_name[]" id="variant_name" type="text" placeholder="Enter Variant Name" required>';
		upends += '		</div>';
		upends += '		<div class="col-md-6">';
		upends += '			<label class="form-label" >Variants(,)</label>';
		upends += '			<input class="form-control" name="variants[]" id="variants" type="text" placeholder="Enter Variants" required>';
		upends += '		</div>';
		upends += '		<div class="col-md-2 align-self-end">';
		upends += '			<button class="btn btn-danger b-0" onclick="remove_variant('+uid+')"  type="button">remove</button>';
		upends += '		</div>';
		upends += '	</div>';
		$('#product_variant').append(upends);
	});
	
	//for remove variant
	function remove_variant(id){
		$('#'+id).remove();
	}
	
    </script>
    
@endsection