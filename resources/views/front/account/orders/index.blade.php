@extends('front.layouts.index')

@section('seo')
		<title>Bajarang | Orders</title>
@endsection

@section('custom_css')  
<style>
	th, td{
		text-align: center;
	}
</style>

@endsection

@section('content')

	<section id="nevigation-header">
		<h3>Order History</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Order History</p>
	</section>
  
	<section class="mt-5 mb-5 pb-5">
		<div class="container" style="overflow: auto;">
			@if(isset($order_data) && !empty($order_data))
				<table class="table" >
					<tr>
						<th>Order ID</th>
						<th>Date & Time</th>
						<th>Customer Name</th>
						<th>Location</th>
						<th>Amount</th>
						<th>Status Order</th>
						<th></th>
					</tr>
					@foreach($order_data as $val)
					<tr>
						<td>{{ $val->id }}</td>
						<td>{{ date_format(date_create($val->created_at), 'd-m-Y H:i:s') }}</td>
						<td>{{ $val->name }}</td>
						<td>{{ $val->address }}</td>
						<td>Rs. {{ $val->total }}</td>
						<td>@if(isset($val->order_status) && !empty($val->order_status))
								<i class="badge {{ $val->order_status->badge_style }}">{{ $val->order_status->name }}</i>
							@endif
						</td>
						<td>
							<a href="{{ url('/pdf_invoice/'.$val->id) }}" title="Invoice"><i class="btn btn-primary fa-solid fa-file-pdf "></i> </a>
							<a href="{{ route('account.order.detail', $val->id ) }}" title="Order Details"><i class="btn btn-primary fa-solid fa-eye "></i> </a>
						</td>
					</tr>
					@endforeach
				</table>
				<div class="d-flax " >
					{{ $order_data->appends(request()->except('page'))->links() }}
				</div>
				
			@else
				<div class="text-center">
				
					<p class="h4 font-wieght-bold mt-5" > Your Orders is empty</p>
					<p>Looks like you have not added anything to your cart. Go ahead & explore top categories.</p>
					<a class="btn btn-primary btn-round pr-3 pl-3 mt-3" href="{{ route('Products') }}"> Return To Shop </a>
				</div>
			@endif
			
			
		</div>
	</section>
	
@endsection

@section('custom_js')  
<script>	
	
</script>	

@endsection

