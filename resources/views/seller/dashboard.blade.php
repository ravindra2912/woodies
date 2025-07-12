@extends('seller.layouts.index')

@section('content')
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Dashboard</h1>
				</div>
			</div>
		</div>
	</div>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				@if (Auth::user()->role_id == 1)
				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3>{{ (isset($total_category_count) && !empty($total_category_count)) ? $total_category_count : 0 }}</h3>
							<p>Total Category</p>
						</div>
						<div class="icon">
							<i class="ion ion-bag"></i>
						</div>
						<a href="{{ route('category.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				@endif

				<div class="col-lg-3 col-6">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3>{{ (isset($total_product_count) && !empty($total_product_count)) ? $total_product_count : 0 }}</h3>
							<p>Total Products</p>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="{{ route('product.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-purple">
						<div class="inner">
							<h3>{{ (isset($total_Coupon_count) && !empty($total_Coupon_count)) ? $total_Coupon_count : 0 }}</h3>
							<p>Total Coupons</p>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="{{ route('coupons.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-pink">
						<div class="inner">
							<h3>{{ (isset($total_Orders_count) && !empty($total_Orders_count)) ? $total_Orders_count : 0 }}</h3>
							<p>Total Order</p>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<a href="{{ route('Order.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>

				<div class="col-lg-6 col-12">
					<div class="card">
						<div class="card-header border-0">
							<h3 class="card-title">Low Quantity Product</h3>
							<!-- div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div -->

							<div class="card-tools mt-2">
								{{$low_qty_product->appends(['low_qty' => $low_qty_product->currentPage()])->links()}}
							</div>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-striped table-valign-middle">
								<thead>
									<tr>
										<th>variant</th>
										<th>Product</th>
										<th>Price</th>
										<th>QTY</th>
										<th>More</th>
									</tr>
								</thead>
								<tbody>
									@if(isset($low_qty_product) && count($low_qty_product) > 0)
									@foreach($low_qty_product as $lqp)
									<tr>
										<td>
											<!-- img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2" -->
											{{ $lqp->variants }}
										</td>
										<td>
											<!-- img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2" -->
											{{ $lqp->name }}
										</td>
										<td class="text-danger">Rs. {{ $lqp->amount }}</td>
										<td class="text-danger">{{ $lqp->qty }}</td>
										<td>
											@if ($lqp->type == 'product')
											<a href="{{ route('product.edit',$lqp->product_id) }}" class="text-muted">
												<i class="fas fa-share-square"></i>
											</a>
											@else
											<a href="{{ route('products_variants',$lqp->product_id) }}" class="text-muted">
												<i class="fas fa-share-square"></i>
											</a>
											@endif

										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td colspan="5" class="text-center">No Data Found</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-lg-6 col-12">
					<div class="card">
						<div class="card-header border-0">
							<h3 class="card-title">Latest Orders</h3>
							<!-- div class="card-tools">
					  <a href="#" class="btn btn-tool btn-sm">
						<i class="fas fa-download"></i>
					  </a>
					  <a href="#" class="btn btn-tool btn-sm">
						<i class="fas fa-bars"></i>
					  </a>
					</div -->

							<div class="card-tools">
								{{$orderLists->appends(['orders' => $orderLists->currentPage()])->links()}}
							</div>
						</div>
						<div class="card-body table-responsive p-0">
							<table class="table table-striped table-valign-middle">
								<thead>
									<tr>
										<th>User</th>
										<th>Amount</th>
										<th>Order Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if(isset($orderLists) && count($orderLists)> 0)
									@foreach($orderLists as $ordertList)
									@php
									$status = (isset($ordertList->order_status) && !empty($ordertList->order_status)) ? $ordertList->order_status->name :'';
									$status_style = (isset($ordertList->order_status) && !empty($ordertList->order_status)) ? $ordertList->order_status->badge_style :'';
									@endphp
									<tr>
										<td>{{ $ordertList->contact }}</td>
										<td>₹ {{ $ordertList->total }}</td>
										<td>{{ date_format(date_create($ordertList->created_at), 'd-m-Y') }}</td>
										<td>
											<div class="{{ $status_style }}">{{ $status }}</div>
										</td>
										<td>
											<a href="{{ route('Order.edit',$ordertList->id) }}" class="text-muted">
												<i class="fas fa-share-square"></i>
											</a>
										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td colspan="5" class="text-center">No Data Found</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-lg-12 col-12">
					<div class="card">
						<div class="card-header border-0">
							<div class="d-flex justify-content-between">
								<h3 class="card-title">Sales</h3>
								<!-- a href="javascript:void(0);">View Report</a -->
							</div>
						</div>
						<div class="card-body">
							<div class="d-flex">
								<p class="d-flex flex-column">
									<span class="text-bold text-lg">$18,230.00</span>
									<span>Sales Over Time</span>
								</p>
								<p class="ml-auto d-flex flex-column text-right">
									<span class="text-success">
										<i class="fas fa-arrow-up"></i> 33.1%
									</span>
									<span class="text-muted">Since last month</span>
								</p>
							</div>
							<!-- /.d-flex -->

							<div class="position-relative mb-4">
								<canvas id="sales-chart" height="200"></canvas>
							</div>

							<div class="d-flex flex-row justify-content-end">
								<span class="mr-2">
									<i class="fas fa-square text-primary"></i> This year
								</span>

								<span>
									<i class="fas fa-square text-gray"></i> Last year
								</span>
							</div>
						</div>
					</div>
					<!-- /.card -->
				</div>

			</div>
		</div>
	</section>
</div>

@endsection

@section('custom_js')
<!-- ChartJS -->
<script src="{{ asset('admin_theme/plugins/chart.js/Chart.min.js') }}"></script>
<script>
	$(function() {

		function load_sales_chart(result) {
			'use strict'

			var ticksStyle = {
				fontColor: '#495057',
				fontStyle: 'bold'
			}

			var mode = 'index'
			var intersect = true

			var $salesChart = $('#sales-chart')
			var salesChart = new Chart($salesChart, {
				type: 'bar',
				data: {
					labels: result.data.labels,
					datasets: [{
							backgroundColor: '#007bff',
							borderColor: '#007bff',
							data: result.data.data1
						},
						{
							backgroundColor: '#ced4da',
							borderColor: '#ced4da',
							data: result.data.data2
						}
					]
				},
				options: {
					maintainAspectRatio: false,
					tooltips: {
						mode: mode,
						intersect: intersect
					},
					hover: {
						mode: mode,
						intersect: intersect
					},
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							// display: false,
							gridLines: {
								display: true,
								lineWidth: '4px',
								color: 'rgba(0, 0, 0, .2)',
								zeroLineColor: 'transparent'
							},
							ticks: $.extend({
								beginAtZero: true,

								// Include a dollar sign in the ticks
								callback: function(value, index, values) {
									if (value >= 1000) {
										value /= 1000
										value += 'k'
									}
									return '$' + value
								}
							}, ticksStyle)
						}],
						xAxes: [{
							display: true,
							gridLines: {
								display: false
							},
							ticks: ticksStyle
						}]
					}
				}
			})
		}

		$.ajax({
			type: "get",
			url: "{{ route('seller.dashboard.get_sales_chart_data') }}",
			dataType: "json",
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			//data:{ product_variant_id:product_variant_id, alert_qty:alert_qty },
			success: function(result) {
				if (result.success) {
					load_sales_chart(result);
				} else {
					toastr.error(result.message);
				}
			},
			error: function(e) {
				//alert("Somthing Wrong");
				console.log(e);
			}
		});





	})
</script>


@endsection