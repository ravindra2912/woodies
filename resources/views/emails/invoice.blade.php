<!doctype html>

    <html lang="en">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> Invoice</title>
		<style>
			body{
				font-family: DejaVu Sans;
			}
			.invoice-text{
				margin: 0; background: white; width: fit-content; padding: 0px 15px; font-size: 35px; float: right; margin-right: 15%;
			}
			.m-0{
				margin: 0px;
			}
			.item-table{
				border: 2px solid gray;
				margin-top: 15px;
				margin-bottom: 10px;
			}
			
			.item-table, tr, td{
				border-spacing: unset;
			}
			.item-table td{
				padding: 10px;
			}
		</style>
    </head>
    <body>
		<div style="padding: 10px; border-bottom: 5px solid #fdca36; padding-bottom: 40px;">
			<table width="100%">
				<tr>
					<td><img src="{{ config('const.site_setting.logo') }}" alt="{{ config('const.site_setting.name') }} Logo"></td>
				</tr>
				<tr>
					<td>
						<div style="background: #fdca36; height: 40px; border-radius: 5px;">
							<p class="invoice-text">INVOICE</p>
						</div>
					</td>
				</tr>
				<tr>
					<table width="100%">
						<tr>
							<td>
								<h2>Invoice To:</h2>
								<h4 class="m-0">{{ $order_data->name }} </h4>
								<p class="m-0">
									{{ $order_data->address }}, 
									{{ $order_data->address2 }}<br>
									{{ $order_data->country.', '.$order_data->state.', '.$order_data->city.', '.$order_data->zipcode }}
								</p>
								<p class="m-0">+91 {{ $order_data->contact }}</p>
							</td>
							<td>
								<p class="m-0"><b>Invoice# :</b> {{ $order_data->id }}</p>
								<p class=""><b>Date :</b> {{ date_format(date_create($order_data->created_at), 'Y-m-d') }}</p>
							</td>
						</tr>
					</table>
				</tr>
				<tr>
					<table width="100%" class="item-table">
						<tr style="background: #2b2929; color: white;">
							<td>Item </td>
							<td>Price</td>
							<td>QTY</td>
							<td>Total</td>
						</tr>
						@foreach($order_data->order_items_data as $val)
							<tr>
								<td>{{ $val->product_name }}<br> ({{ $val->Variant }})</td>
								<td>Rs. {{ $val->product_price }}</td>
								<td>{{ $val->quantity }}</td>
								<td>Rs. {{ $val->product_price * $val->quantity }}</td>
							</tr>
						@endforeach
					</table>
				</tr>
				<tr>
					<table width="100%">
						<tr>
							<td width="70%">
								<h4>Thank You For Order</h4> 
								<h4 class="m-0">Term & Condition</h4> 
								<p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi feugiat velit urna, sed tincidunt est fermentum id.</p>
							</td>
							<td>
								<table width="100%">
									<tr>
										<td ><b>Sub Total :</b></td>
										<td style="text-align: right;">Rs. {{ $order_data->subtotal }}</td>
									</tr>
									<tr>
										<td ><b>Shipping :</b></td>
										<td style="text-align: right;">Rs. {{ $order_data->shipping }}</td>
									</tr>
									<tr>
										<td ><b>Discount :</b></td>
										<td style="text-align: right;">Rs. {{ $order_data->discount }}</td>
									</tr>
									<tr>
										<td ><b>Tax :</b></td>
										<td style="text-align: right;">Rs. {{ $order_data->tax }}</td>
									</tr>
									<tr  style="background: #fdca36;">
										<td style="padding: 13px 5px; border-radius: 5px;" colspan="2"><b>Total :</b><span style="float: right;">Rs. {{ $order_data->total }}</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</tr>
				
			</table>
			
		</div>
		  
		</div>
     </body>
    </html>