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
                            </div>
							<div class="card-body">
								<table class="table">
									<tr>
										<td>Order Id<td>
										<td>:<td>
										<td><b>#{{ $order->id}}<b><td>
									</tr>
									<tr>
										<td>Order By<td>
										<td>:<td>
										<td>{{ ucfirst($order->user_data->first_name).' '.ucfirst($order->user_data->last_name)}}<td>
									</tr>
									<tr>
										<td>Order Date<td>
										<td>:<td>
										<td>{{ date_format(date_create($order->created_at), 'd-m-Y h:i:s a') }}<td>
									</tr>
									
									@php
										$status = (isset($order->order_status) && !empty($order->order_status)) ? $order->order_status->name :'';
										$status_style = (isset($order->order_status) && !empty($order->order_status)) ? $order->order_status->badge_style :'';
									@endphp
									<tr>
										<td style="padding-top: 25px;">Order Status<td>
										<td style="padding-top: 25px;">:<td>
										<td class="text-center"><span class="{{ $status_style }}" >{{ $status }}</span>
										
											<select class="form-control mt-2" name="status" id="status" onchange="change_order_status({{ $order->id }}, this.value)">	
												<option value="">All </option>	
												@foreach($orderstaus as $os)
													<option value="{{ $os->id }}" {{ ($order->status == $os->id) ? 'selected':'' }}>{{ $os->name }} </option>	
												@endforeach					
											</select>
											
										<td>
									</tr>
									
									
									
								</table>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-6 col-sm-6 detailstable">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Delivery Details</h3>
                            </div>
							<div class="card-body">
								<table class="table">
									<tr>
										<td>Name<td>
										<td>:<td>
										<td>{{ ucfirst($order->name)}}<td>
									</tr>
									<tr>
										<td>Contact<td>
										<td>:<td>
										<td>{{ $order->contact }}<td>
									</tr>
									<tr>
										<td>Address<td>
										<td>:<td>
										<td>{{ $order->address }}<td>
									</tr>
									<tr>
										<td>Address 2<td>
										<td>:<td>
										<td>{{ $order->address2 }}<td>
									</tr>
									<tr>
										<td>Country<td>
										<td>:<td>
										<td>{{ $order->country }}<td>
									</tr>
									<tr>
										<td>State<td>
										<td>:<td>
										<td>{{ $order->state }}<td>
									</tr>
									<tr>
										<td>City<td>
										<td>:<td>
										<td>{{ $order->city }}<td>
									</tr>
									<tr>
										<td>Zipcode<td>
										<td>:<td>
										<td>{{ $order->zipcode }}<td>
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
								@foreach($order->order_items_data as $items)
									<tr>
										<td>{{ ucfirst($items->product_name)}}<td>
										<td>₹ {{ ucfirst($items->product_price)}}<td>
										<td>{{ ucfirst($items->quantity)}}<td>
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
										<td>SubTotal<td>
										<td>:<td>
										<td>₹ {{ $order->subtotal}}<td>
									</tr>
									
									<tr>
										<td>Discount<td>
										<td>:<td>
										<td>₹ {{ $order->discount}}<td>
									</tr>
									
									<tr>
										<td>Tax<td>
										<td>:<td>
										<td>₹ {{ $order->tax}}<td>
									</tr>
									
									<tr>
										<td>Total<td>
										<td>:<td>
										<td>₹ {{ $order->total}}<td>
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
											<td class="text-center"><span class="{{ $status_style }}" >{{ $status }}</span><td>
											<td>:<td>
											<td>{{ date_format(date_create($val->created_at), 'd-m-Y H:i:s')	 }}
												@if(!empty($val->order_note))
													<p class="mb-0"><b>Note : </b> {{ $val->order_note }}</p>
												@endif
											<td>
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
@endsection

@section('custom_js')
    <script type="text/javascript">

        function change_order_status(id, status){

                $.ajax({
                    type: "POST",
                    url: " {{ route('change-order-status') }}",
                    dataType: "json",
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    data : {
                        'id': id,
                        'status': status,
                    },
                    success: function(result){
                        if(result.success){
                            toastr.success(result.message);
							location.reload();
                        }
                        else{
                            toastr.error(result.message);
                        }
                    },
					error: function(e){
                        console.log(e);
                    }
                });
            }
    </script>
@endsection