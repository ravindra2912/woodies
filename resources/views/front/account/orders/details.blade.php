@extends('front.layouts.index')

@section('seo')
		<title>Bajarang | Order Details</title>
@endsection

@section('custom_css')  
<!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
	.profile-img{
		height: 50px;
		width: 50px;
		object-fit: cover;
		border-radius: 100%;
		float: left;
		margin-right: 10px;
	}

	.product-img{
		height: 80px;
    width: 80px;
    object-fit: contain;
	}
	
	.info .card{
		background: #525252;
		color: white;
	}
	
	.info .card .heads{
		border-bottom: 1px solid gray;
	}
	
	<!-- timeline -->
	body{margin-top:20px;}
		.timeline-steps {
			display: flex;
			justify-content: center;
			flex-wrap: wrap
		}

		.timeline-steps .timeline-step {
			align-items: center;
			display: flex;
			flex-direction: column;
			position: relative;
			margin: 1rem
		}

		@media (min-width:768px) {
			.timeline-steps .timeline-step:not(:last-child):after {
				content: "";
				display: block;
				border-top: .25rem dotted gray;
				width: 3.46rem;
				position: absolute;
				left: 7.5rem;
				top: .3125rem
			}
			.timeline-steps .timeline-step:not(:first-child):before {
				content: "";
				display: block;
				border-top: .25rem dotted gray;
				width: 3.8125rem;
				position: absolute;
				right: 7.5rem;
				top: .3125rem
			}
			
			.timeline-steps  .active:not(:last-child):after {
				border-top: .25rem dotted #3b82f6;
			}
			.timeline-steps .active:not(:first-child):before {
				border-top: .25rem dotted #3b82f6;
			}
		}

		.timeline-steps .timeline-content {
			width: 10.2rem;
			text-align: center
		}

		.timeline-steps .timeline-content .inner-circle {
			border-radius: 1.5rem;
			height: 1rem;
			width: 1rem;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			background-color: gray;
		}

		.timeline-steps .timeline-content .inner-circle:before {
			content: "";
			background-color: gray;
			display: inline-block;
			height: 3rem;
			width: 3rem;
			min-width: 3rem;
			border-radius: 6.25rem;
			opacity: .5
		}
		
		.timeline-steps .active .timeline-content .inner-circle{
			background-color: #3b82f6;
		}
		
		.timeline-steps .active .timeline-content .inner-circle:before {
			background-color: #3b82f6;
		}
</style>

@endsection

@section('content')

	<section id="nevigation-header">
		<h3>Order History</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Order History <i class="fa-solid fa-angle-right"></i> Order Details</p>
	</section>
  
	<section class="mt-5 mb-5 pb-5">
		<div class="container">
			@if(isset($order_data) && !empty($order_data))
				
			
				<div class="row">
					<div class="col-md-12">
						<h4><b>Order ID</b> #{{ $order_data->id }}</h4>
						<p>Orders History / Order Details</p>
					</div>
					<!-- <div class="col-md-6 info">
						<div class="card">
							<div class="card-body">
								<div class="heads">
									<img class="profile-img" src="{{ isset($order_data->user_data) ? getImage($order_data->user_data->image) : '' }}" />
									<div>
										<p class="mb-0">{{ (isset($order_data->user_data) && !empty($order_data->user_data) ) ? $order_data->user_data->first_name.' '.$order_data->user_data->last_name  : '' }}</p>
										<p>Customer</p>
									</div>
								</div>
								<div class="heads">
									<p class="mt-2">Note Order</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div>
								<div class="mt-2 row justify-content-center">
									<div class="col-md-2 col-3 align-self-center text-center">
										<i class="fa-solid fa-house-chimney h3"></i>
									</div>
									<div class="col-md-7 col-6">
										<p class="mb-0">Address</p>
										<p>
											{{ $order_data->address }}, 
											{{ $order_data->address2 }}<br>
											{{ $order_data->country.', '.$order_data->state.', '.$order_data->city.', '.$order_data->zipcode }}
										</p>
									</div>
								</div>
								<div class="mt-2 row justify-content-center">
									<div class="col-md-6 col-12 d-flex align-items-center justify-content-center">
										<div>
											<i class="fa-solid fa-phone h4 mr-3"></i>
										</div>
										<div>
											<p class="mb-0">Call</p>
											<p class="mb-0">+ 01 234 567 88</p>
										</div>
									</div>
									<div class="col-md-6 col-12 d-flex align-items-center justify-content-center">
										<div>
											<i class="fa-solid fa-truck-fast h4 mr-3"></i>
										</div>
										<div>
											<p class="mb-0">Delivery Date</p>
											<p class="mb-0">{{ date_format(date_create($order_data->delivery_date), 'd-M-Y') }}</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->

					<div class="col-md-6 info">
						<div class="card">
							<div class="card-body">
								<!-- <div class="heads">
									<img class="profile-img" src="{{ isset($order_data->user_data) ? getImage($order_data->user_data->image) : '' }}" />
									<div>
										<p class="mb-0">{{ (isset($order_data->user_data) && !empty($order_data->user_data) ) ? $order_data->user_data->first_name.' '.$order_data->user_data->last_name  : '' }}</p>
										<p>Customer</p>
									</div>
								</div> -->
								<!-- <div class="heads">
									<p class="mt-2">Note Order</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
								</div> -->
								<div class="mt-2 row justify-content-center">
									<div class="col-md-2 col-3 align-self-center text-center">
										<i class="fa-solid fa-house-chimney h3"></i>
									</div>
									<div class="col-md-7 col-6">
										<strong>Shipping Address</strong>
										<p class="mb-0">{{ $order_data->name }}</p>
										<p>
											{{ $order_data->address }}, 
											{{ $order_data->address2 }}<br>
											{{ $order_data->country.', '.$order_data->state.', '.$order_data->city.', '.$order_data->zipcode }}
										</p>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<table class="table">
							@if(isset($order_data->order_items_data) && !empty($order_data->order_items_data))
								<tr>
									<th>Items</th>
									<th></th>
									<th>Qty</th>
									<th>Price</th>
									<th>Total Price</th>
								<tr>
								@foreach($order_data->order_items_data as $val)
									</tr>
										<td><img src="{{ $val->image }}" class="product-img" /></td>
										<td>{{ $val->product_name }}<br> {{ $val->Variant != null?'('.$val->Variant.')':'' }}</td>
										<td>{{ $val->quantity }}</td>
										<td>Rs. {{ $val->product_price }}</td>
										<td>Rs. {{ $val->product_price * $val->quantity }}</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="4" class="text-right font-weight-bold">Subtotal : </td>
									<td>Rs. {{ $order_data->subtotal }}</td>
								</tr>
								<tr>
									<td colspan="4" class="text-right font-weight-bold">Shipping : </td>
									<td>Rs. {{ $order_data->shipping }}</td>
								</tr>
								<tr>
									<td colspan="4" class="text-right font-weight-bold">Discount : </td>
									<td>Rs. {{ $order_data->discount }}</td>
								</tr>
								<tr>
									<td colspan="4" class="text-right font-weight-bold">Tax : </td>
									<td>Rs. {{ $order_data->tax }}</td>
								</tr>
								<tr>
									<td colspan="4" class="text-right font-weight-bold">Total : </td>
									<td>Rs. {{ $order_data->total }}</td>
								</tr>
							@endif
							
						</table>
					</div>
					<div class="col-md-12 m-5">
						                    
							
							<!-- <p class="h4 font-weight-bold">Order History</p>
							<p>Lorem ipsum dolor</p> -->
							
							@php 
								$step1= true;
								$step2= ($order_data->payment_status == 1)? true : false;
								$step3= false;
								$step4= false;
							@endphp 
							
							<div class="row">
								<div class="col">
									<div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
										
										<div class="timeline-step {{ ($step1 == true)? 'active' : '' }}">
											<div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
												<div class="inner-circle"></div>
												<p class="h6 mt-3 mb-1">{{ date_format(date_create($order_data->created_at), 'd-m-Y H:i:s') }}</p>
												<p class="h6 text-muted mb-0 mb-lg-0">Order Created</p>
											</div>
										</div>
										
										<div class="timeline-step {{ ($step2 == true)? 'active' : '' }}">
											<div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
												<div class="inner-circle"></div>
												<p class="h6 mt-3 mb-1">{{ date_format(date_create($order_data->created_at), 'd-m-Y H:i:s') }}</p>
												<p class="h6 text-muted mb-0 mb-lg-0">Payment Success</p>
											</div>
										</div>
									
										@if($order_data->status >= 2 && $order_data->status <= 6)
											<div class="timeline-step {{ ($order_data->status == 6)? 'active' : '' }}">
												<div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
													<div class="inner-circle"></div>
													<p class="h6 mt-3 mb-1">{{ date_format(date_create($order_data->delivery_date), 'd-m-Y H:i:s') }}</p>
													<p class="h6 text-muted mb-0 mb-lg-0">On Delivery</p>
												</div>
											</div>
											<div class="timeline-step {{ ($order_data->status == 6)? 'active' : '' }}">
												<div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
													<div class="inner-circle"></div>
													<p class="h6 mt-3 mb-1">{{ ($order_data->status == 6)? date_format(date_create($order_data->delivery_date), 'd-m-Y H:i:s') : 'Wait ....' }}</p>
													<p class="h6 text-muted mb-0 mb-lg-0">Order Delivered</p>
												</div>
											</div>
										@elseif($order_data->status == 7 || $order_data->status == 8)
											<div class="timeline-step active">
												<div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
													<div class="inner-circle"></div>
													<p class="h6 mt-3 mb-1">{{ date_format(date_create($order_data->updated_at), 'd-m-Y H:i:s') }}</p>
													<p class="h6 text-muted mb-0 mb-lg-0">Order Canceled</p>
												</div>
											</div>
										@elseif($order_data->status == 9 || $order_data->status == 10)
											<div class="timeline-step {{ ($order_data->return_at != null)? 'active' : '' }}">
												<div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
													<div class="inner-circle"></div>
													<p class="h6 mt-3 mb-1">{{ date_format(date_create($order_data->return_at), 'd-m-Y H:i:s') }}</p>
													<p class="h6 text-muted mb-0 mb-lg-0">Order Return</p>
												</div>
											</div>
											<div class="timeline-step {{ ($order_data->return_receive_at != null)? 'active' : '' }}">
												<div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
													<div class="inner-circle"></div>
													<p class="h6 mt-3 mb-1">{{ ($order_data->return_receive_at != null)? date_format(date_create($order_data->return_receive_at), 'd-m-Y H:i:s') : 'Wait ...' }} </p>
													<p class="h6 text-muted mb-0 mb-lg-0">Order Return Receive</p>
												</div>
											</div>
										@endif
										
									</div>
								</div>
							</div>
					</div>
					
					@if($order_data->status >= 2 && $order_data->status <= 4)
						
							<button class="btn btn-primary btn-round" data-toggle="modal" data-target="#cancelmodal">Cancel Order</Button>
						
							<div class="modal fade" id="cancelmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal-md" role="document">
									<form action="{{ route('order.cancel_order') }}" id="cencel_form" class="modal-content">{{ csrf_field() }}
										<div class="modal-header">
											<h5 class="modal-title">Cancel Order</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
												<input type="hidden" name="order_id" value="{{ $order_data->id }}" />
												<div class="form-group col-lg-12 col-md-12 col-12">
													<label>Cancel Reason</label>
													<textarea name="cancel_reason" class="form-control" placeholder="Enter..."></textarea>
												</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary loading" style="display:none;">Loading ...</button>
											<button type="submit" class="btn btn-primary submit_button">Submit</button>
										</div>
									</form>
								</div>
							</div>
						
					@endif
					
					@if($order_data->status == 6)
						
							<button class="btn btn-primary btn-round" data-toggle="modal" data-target="#returnmodal">Return Order</Button>
						
							<div class="modal fade" id="returnmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal-md" role="document">
									<form action="{{ route('order.order_return') }}" id="return_form" class="modal-content">{{ csrf_field() }}
										<div class="modal-header">
											<h5 class="modal-title">Return Order</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
												<input type="hidden" name="order_id" value="{{ $order_data->id }}" />
												<div class="form-group col-lg-12 col-md-12 col-12">
													<label>Return Reason</label>
													<textarea name="return_reason" class="form-control" placeholder="Enter..."></textarea>
												</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-primary loading" style="display:none;">Loading ...</button>
											<button type="submit" class="btn btn-primary submit_button">Submit</button>
										</div>
									</form>
								</div>
							</div>
					@endif
				</div>
				
				<div class="text-center">
					<a class="btn btn-primary btn-round" href="{{ url('/pdf_invoice/'.$order_data->id) }}" title="Invoice">Invoice</a>
				</div>
				
				
			@else
				<div class="text-center">
					<p class="h4 font-wieght-bold mt-5" > Your Orders is empty</p>
				</div>
			@endif
			
			
		</div>
	</section>
	
@endsection

@section('custom_js')  
<script>	
	$("#cencel_form").on('submit',(function(e) {
		  e.preventDefault();
			Swal.fire({
				title: 'Are you sure?',
				icon: 'error',
				html: "You want to Cancel this Order?",
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonText: 'Sure',
				cancelButtonText: 'Cancel',
			})
			.then((result) => {
				if (result.isConfirmed) {
					var form = this;
					$.ajax({
						url: this.action,
						type: "POST",
						data:  new FormData(this),
						dataType: "json",
						headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
						contentType: false,
						cache: false,
						processData:false,
						beforeSend : function(){ 
							$('.submit_button').hide();
							$('.loading').show();
						},
						success: function(result){
							//console.log(result);
							
							if(result.success){
							  toastr.success(result.message);
							  location.reload();
							}
							else{
								if(result.auth == false){
									location.reload();
								}else{
									toastr.error(result.message);
								}
							}
							$('.submit_button').show();
							$('.loading').hide();
						},
						error: function(e){ 
							//console.log(e);
							var e = eval("(" + e.responseText + ")");
							if(e.message == "CSRF token mismatch."){ 
								toastr.error('Your session has expired');
								setTimeout(function() { location.reload(); }, 3000);
							}else{
								toastr.error('Something Wrong');
							}
						}           
					});
				}
			})
		}));
		
		$("#return_form").on('submit',(function(e) {
		  e.preventDefault();
			Swal.fire({
				title: 'Are you sure?',
				icon: 'error',
				html: "You want to Return this Order?",
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonText: 'Sure',
				cancelButtonText: 'Cancel',
			})
			.then((result) => {
				if (result.isConfirmed) {
					var form = this;
					$.ajax({
						url: this.action,
						type: "POST",
						data:  new FormData(this),
						dataType: "json",
						headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
						contentType: false,
						cache: false,
						processData:false,
						beforeSend : function(){ 
							$('.submit_button').hide();
							$('.loading').show();
						},
						success: function(result){
							//console.log(result);
							
							if(result.success){
							  toastr.success(result.message);
							  location.reload();
							}
							else{
								if(result.auth == false){
									location.reload();
								}else{
									toastr.error(result.message);
								}
							}
							$('.submit_button').show();
							$('.loading').hide();
						},
						error: function(e){ 
							//console.log(e);
							var e = eval("(" + e.responseText + ")");
							if(e.message == "CSRF token mismatch."){ 
								toastr.error('Your session has expired');
								setTimeout(function() { location.reload(); }, 3000);
							}else{
								toastr.error('Something Wrong');
							}
						}           
					});
				}
			})
		}));
		
		
</script>	

@endsection

