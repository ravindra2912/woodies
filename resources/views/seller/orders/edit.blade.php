@extends('seller.layouts.index')

@section('custom_css')
    
	<style>
	.detailstable td:first-child { 
		font-weight: 900; 
		text-align: end;
	};
</style>
    <!-- Summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
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
                <div class="row">
                    <div class="col-md-6 col-sm-6 detailstable">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Order Details</h3>
								<i data-toggle="modal" data-target="#modal-order-update" class="fas fa-edit float-right"></i>
                            </div>
							<div class="card-body">
								<table class="table">
									<tr>
										<td>Order Id</td>
										<td>:</td>
										<td><b>#{{ $order->id}}<b></td>
									</tr>
									<tr>
										<td>Order By</td>
										<td>:</td>
										<td>{{ ucfirst($order->user_data->first_name).' '.ucfirst($order->user_data->last_name)}}</td>
									</tr>
									<tr>
										<td>Order Date</td>
										<td>:</td>
										<td>{{ get_date($order->created_at) }}</td>
									</tr>
									<tr>
										<td>Payment Type</td>
										<td>:</td>
										<td>
											@if($order->payment_type == 1)
												<span class="badge badge-success">Online</span>
											@elseif($order->payment_type == 2)
												<span class="badge badge-info">COD</span>
											@endif
										</td>
									</tr>
									
									<tr>
										<td>Payment Status</td>
										<td>:</td>
										<td>
											@if($order->payment_status == 1)
												<span class="badge badge-success">SUCCESS</span>
											@elseif($order->payment_status == 2)
												<span class="badge badge-danger">FAIL</span>
											@elseif($order->payment_status == 3)
												<span class="badge badge-info">Refund</span>
											@else
												<span class="badge badge-warning">PENDING</span>
											@endif
										</td>
									</tr>
									
									@php
										$status = (isset($order->order_status) && !empty($order->order_status)) ? $order->order_status->name :'';
										$status_style = (isset($order->order_status) && !empty($order->order_status)) ? $order->order_status->badge_style :'';
									@endphp
									<tr>
										<td style="padding-top: 25px;">Order Status</td>
										<td style="padding-top: 25px;">:</td>
										<td><span class="{{ $status_style }}" >{{ $status }}</span></td>
									</tr>
									
									@if($order->status >= 2 && $order->status <= 6)
									<tr>
										<td>Delivery Date</td>
										<td>:</td>
										<td>{{ get_date($order->delivery_date, 'd-m-Y') }}</td>
									</tr>
									@elseif($order->status == 7 || $order->status == 8)
									<tr>
										<td>Cancel Reason</td>
										<td>:</td>
										<td>{{ ucfirst($order->return_reason) }}</td>
									</tr>
									@elseif($order->status == 9 || $order->status == 10)
									<tr>
										<td>Return Reason</td>
										<td>:</td>
										<td>{{ ucfirst($order->return_reason) }}</td>
									</tr>
									<tr>
										<td>Return Date</td>
										<td>:</td>
										<td>{{ get_date($order->return_at) }}</td>
									</tr>
									<tr>
										<td>Return Receive Date</td>
										<td>:</td>
										<td>{{ ($order->return_receive_at != null) ? get_date($order->return_receive_at) : '' }}</td>
									</tr>
									@endif
									
								</table>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-6 col-sm-6 detailstable">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Delivery Details</h3>
								<i data-toggle="modal" data-target="#modal-order-address-update" class="fas fa-edit float-right"></i>
                            </div>
							<div class="card-body">
								<table class="table">
									<tr>
										<td>Name</td>
										<td>:</td>
										<td>{{ ucfirst($order->name)}}</td>
									</tr>
									<tr>
										<td>Contact</td>
										<td>:</td>
										<td>{{ $order->contact }}</td>
									</tr>
									<tr>
										<td>Address</td>
										<td>:</td>
										<td>{{ $order->address }}</td>
									</tr>
									<tr>
										<td>Address 2</td>
										<td>:</td>
										<td>{{ $order->address2 }}</td>
									</tr>
									<tr>
										<td>Country</td>
										<td>:</td>
										<td>{{ $order->country }}</td>
									</tr>
									<tr>
										<td>State</td>
										<td>:</td>
										<td>{{ $order->state }}</td>
									</tr>
									<tr>
										<td>City</td>
										<td>:</td>
										<td>{{ $order->city }}</td>
									</tr>
									<tr>
										<td>Zipcode</td>
										<td>:</td>
										<td>{{ $order->zipcode }}</td>
									</tr>
									
								</table>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-7 col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Order Items</h3>
                            </div>
							<div class="card-body">
								<table class="table">
								<tr>
									<th>Item</th>
									<th>Price</th>
									<th>QTY</th>
								</tr>
								@foreach($order->seller_order_items_data as $items)
									<tr>
										<td>{{ ucfirst($items->product_name)}}</td>
										<td width="15%">Rs. {{ ucfirst($items->product_price)}}</td>
										<td width="10%">{{ ucfirst($items->quantity)}}</td>
									</tr>
								@endforeach
									
								</table>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-5 col-sm-12 detailstable">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Order Summary</h3>
                            </div>
							<div class="card-body">
								<table class="table">
									<tr>
										<td>SubTotal</td>
										<td>:</td>
										<td>Rs. {{ $order->subtotal}}</td>
									</tr>
									
									<tr>
										<td>Shipping</td>
										<td>:</td>
										<td>Rs. {{ $order->shipping}}</td>
									</tr>
									
									<tr>
										<td>Discount</td>
										<td>:</td>
										<td>Rs. {{ $order->discount}}</td>
									</tr>
									
									<tr>
										<td>Tax</td>
										<td>:</td>
										<td>Rs. {{ $order->tax}}</td>
									</tr>
									
									<tr>
										<td>Total</td>
										<td>:</td>
										<td>Rs. {{ $order->total}}</td>
									</tr>
									
								</table>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-7 col-sm-12 detailstable">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Order Logs</h3>
                            </div>
							<div class="card-body">
								<table class="table">
								
								@if(isset($OrderLog) && !empty($OrderLog))
									@foreach($OrderLog as $val)
									@php
										$status = (isset($val->status_data) && !empty($val->status_data)) ? $val->status_data->name :'';
										$status_style = (isset($val->status_data) && !empty($val->status_data)) ? $val->status_data->badge_style :'';
									@endphp
										<tr>
											<td class="text-center"><span class="{{ $status_style }}" >{{ $status }}</span></td>
											<td>:</td>
											<td>{{ date_format(date_create($val->created_at), 'd-m-Y H:i:s')	 }}
												@if(!empty($val->order_note))
													<p class="mb-0"><b>Note : </b> {{ $val->order_note }}</p>
												@endif
											</td>
										</tr>
									@endforeach
								@endif	
									
								</table>
							</div>
                        </div>
                    </div>
					
					
                </div>
            </div>
        </section>
    </div>
		<!-- Order Detail Update Model -->
		<div class="modal fade" id="modal-order-update">
			<div class="modal-dialog modal-lg">
				<form action="{{ route('Order.change_order_details') }}" id="orderdetailform" method="post" enctype="multipart/form-data" class="modal-content">@csrf
					<input type="hidden" name="id" value="{{ $order->id }}" />
					<div class="modal-header">
						<h4 class="modal-title">Order Detail</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body row">
						<div class="form-group col-sm-6">
							<label>Order Status</label>
							<select class="form-control" name="status" id="status">	
								@foreach($orderstaus as $os)
									<option value="{{ $os->id }}" {{ ($order->status == $os->id) ? 'selected':'' }}>{{ $os->name }} </option>	
								@endforeach					
							</select>
						</div>
						<div class="form-group col-sm-6">       
							<label for="category">Payment Status</label>     
							<select class="form-control" name="payment_status" id="payment_status">	
								<option value="0" {{ ($order->payment_status == 0) ? 'selected':'' }}> PENDING </option>	
								<option value="1" {{ ($order->payment_status == 1) ? 'selected':'' }}> SUCCESS </option>	
								<option value="2" {{ ($order->payment_status == 2) ? 'selected':'' }}> FAIL </option>	
								<option value="3" {{ ($order->payment_status == 3) ? 'selected':'' }}> Refund </option>	
							</select>   
						</div> 
						<div class="form-group col-sm-6">       
							<label>Payment Type</label>     
							<select class="form-control" name="payment_type" id="payment_type">	
								<option value="1" {{ ($order->payment_type == 1) ? 'selected':'' }}> Online </option>	
								<option value="2" {{ ($order->payment_type == 2) ? 'selected':'' }}> COD </option>	
							</select>   
						</div>  
						@if($order->status >= 2 && $order->status <= 6)
							<div class="form-group col-sm-6">       
								<label>Delivery Date</label>     
								<input type="date" name="delivery_date" class="form-control" value="{{ get_date($order->delivery_date, 'Y-m-d') }}" /> 
							</div> 
						@endif
						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary submit_button">Submit</button>
						<button type="button" class="btn btn-primary loading" style="display:none;">Loading ...</button>
					</div>
				</form>
			</div>
		</div>
		
		<!-- Order address Update Model -->
		<div class="modal fade" id="modal-order-address-update">
			<div class="modal-dialog modal-lg">
				<form action="{{ route('Order.change_order_address') }}" id="orderaddressform" method="post" enctype="multipart/form-data" class="modal-content">@csrf
					<input type="hidden" name="id" value="{{ $order->id }}" />
					<div class="modal-header">
						<h4 class="modal-title">Order Address</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body row">
						<div class="form-group col-sm-6">       
							<label>name</label>     
							<input type="text" name="name" class="form-control" value="{{ $order->name }}" /> 
						</div> 
						<div class="form-group col-sm-6">       
							<label>contact</label>     
							<input type="text" name="contact" class="form-control" value="{{ $order->contact }}" /> 
						</div> 
						<div class="form-group col-sm-6">       
							<label>address</label>     
							<input type="text" name="address" class="form-control" value="{{ $order->address }}" /> 
						</div> 
						<div class="form-group col-sm-6">       
							<label>address2</label>     
							<input type="text" name="address2" class="form-control" value="{{ $order->address2 }}" /> 
						</div> 
						<div class="form-group col-sm-6">       
							<label>country</label>     
							<input type="text" name="country" class="form-control" value="{{ $order->country }}" /> 
						</div> 
						<div class="form-group col-sm-6">       
							<label>state</label>     
							<input type="text" name="state" class="form-control" value="{{ $order->state }}" /> 
						</div> 
						<div class="form-group col-sm-6">       
							<label>city</label>     
							<input type="text" name="city" class="form-control" value="{{ $order->city }}" /> 
						</div>
						<div class="form-group col-sm-6">       
							<label>zipcode</label>     
							<input type="text" name="zipcode" class="form-control" value="{{ $order->zipcode }}" /> 
						</div> 
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary submit_button">Submit</button>
						<button type="button" class="btn btn-primary loading" style="display:none;">Loading ...</button>
					</div>
				</form>
			</div>
		</div>
@endsection

@section('custom_js')
    <script type="text/javascript">
	$("#orderdetailform").on('submit',(function(e) {
		  e.preventDefault();
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
					//console.log(data);
					
					if(result.success){
					  toastr.success(result.message);
					  location.reload();
					}
					else{
						toastr.error(result.message);
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e){ 
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}           
			});
		}));
		
		$("#orderaddressform").on('submit',(function(e) {
		  e.preventDefault();
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
					//console.log(data);
					
					if(result.success){
					  toastr.success(result.message);
					  location.reload();
					}
					else{
						toastr.error(result.message);
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e){ 
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}           
			});
		}));
    </script>
@endsection