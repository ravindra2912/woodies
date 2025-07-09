<!doctype html>

<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title> Invoice</title>
	<style>
		body {
			font-family: DejaVu Sans;
		}

		.text-center {
			text-align: center;
		}

		.w-100 {
			width: 100%;
		}

		.p-1 {
			padding: 1rem;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		.td{
			border: 1px solid #bcb6b6;
		}

		

	</style>
</head>

<body>
	<div>
		<table class="w-100">
			<tr>
				<td class="text-center" style="font-size: 20px;">
					<h1 class="invoice-text">CHD12</h1>
				</td>
			</tr>

			<tr>
				<td class="info-table">
					<h3 style="margin-bottom: 0px;">Sales Summary</h3>
					<table class="w-100 ">
						<tr>
							<td class="p-1" style="border: 1px solid #333; padding: 6px 8px;"> From : {{ $invoice_date }}</td>
							<td class="p-1"  style="border: 1px solid #333; padding: 6px 8px;"> To : {{ $invoice_date }}</td>
						</tr> 
					</table>
				</td>
			</tr>
			<tr class="data-table">
				<td>
					<h3> Payment Type Breakdown</h3>
					<table>
						<thead>
							<tr>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">SL No.</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Payment Type</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Cost of Sales</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Total</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Profit</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($record['PaymentTypeBreakdown'] as $data)
							<tr>
								<td class="td">{{ $data['SLNo'] }}</td>
								<td class="td">{{ $data['PaymentType'] }}</td>
								<td class="td">K{{ number_format((float)$data['CostofSales'], 2) }}</td>
								<td class="td">K{{ number_format((float)$data['Total'], 2) }}</td>
								<td class="td">K{{ number_format((float)$data['profit'], 2) }}</td>
							</tr> 
							@endforeach
							<tr>
								<td colspan="2" class="td">Total</td>
								<td class="td">K{{ number_format(collect($record['PaymentTypeBreakdown'])->sum('CostofSales'), 2) }}</td>
								<td class="td">K{{ number_format(collect($record['PaymentTypeBreakdown'])->sum('Total'), 2) }}</td>
								<td class="td">K{{ number_format(collect($record['PaymentTypeBreakdown'])->sum('profit'), 2) }}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			
			<tr class="data-table">
				<td>
					<h3> Top 3 Sellers by Turnover</h3>
					<table>
						<thead>
							<tr>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Stock Code</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Description</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Quantity</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($record['Top3SellersbyTurnover'] as $data)
							<tr>
								<td class="td">{{ $data['StockCode'] }}</td>
								<td class="td">{{ $data['Description'] }}</td>
								<td class="td">{{ number_format((float)$data['Quantity'], 2) }}</td>
								<td class="td">K{{ number_format((float)$data['Total'], 2) }}</td>
							</tr> 
							@endforeach
							<tr>
								<td colspan="2" class="td">Total</td> 
								<td class="td">{{ number_format(collect($record['Top3SellersbyTurnover'])->sum('Quantity'), 2) }}</td>
								<td class="td">K{{ number_format(collect($record['Top3SellersbyTurnover'])->sum('Total'), 2) }}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			
			<tr class="data-table">
				<td>
					<h3> Top 3 Sellers by Qty</h3>
					<table>
						<thead>
							<tr>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Stock Code</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Description</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Quantity</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($record['Top3SellersbyQty'] as $data)
							<tr>
								<td class="td">{{ $data['StockCode'] }}</td>
								<td class="td">{{ $data['Description'] }}</td>
								<td class="td">{{ number_format((float)$data['Quantity'], 2) }}</td>
								<td class="td">K{{ number_format((float)$data['Total'], 2) }}</td>
							</tr> 
							@endforeach
							<tr>
								<td colspan="2" class="td">Total</td> 
								<td class="td">{{ number_format(collect($record['Top3SellersbyQty'])->sum('Quantity'), 2) }}</td>
								<td class="td">K{{ number_format(collect($record['Top3SellersbyQty'])->sum('Total'), 2) }}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			
			<tr class="data-table">
				<td>
					<h3> Top 3 Department Sales</h3>
					<table>
						<thead>
							<tr>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">SL No.</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Department</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($record['Top3DepartmentSales'] as $data)
							<tr>
								<td class="td">{{ $data['SLNo'] }}</td>
								<td class="td">{{ $data['Department'] }}</td>
								<td class="td">K{{ number_format((float)$data['Total'], 2) }}</td>
							</tr> 
							@endforeach
							<tr>
								<td colspan="2" class="td">Total</td> 
								<td class="td">K{{ number_format(collect($record['Top3DepartmentSales'])->sum('Total'), 2) }}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			
			<tr class="data-table">
				<td>
					<h3> Top 3 Cashier Sales</h3>
					<table>
						<thead>
							<tr>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">SL No.</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Cashier</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($record['Top3CashierSales'] as $data)
							<tr>
								<td class="td">{{ $data['SLNo'] }}</td>
								<td class="td">{{ $data['Cashier'] }}</td>
								<td class="td">K{{ number_format((float)$data['Total'], 2) }}</td>
							</tr> 
							@endforeach
							<tr>
								<td colspan="2" class="td">Total</td> 
								<td class="td">K{{ number_format(collect($record['Top3CashierSales'])->sum('Total'), 2) }}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			
			<tr class="data-table">
				<td>
					<h3> Top 3 Computer Sales</h3>
					<table>
						<thead>
							<tr>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">SL No.</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">PC Name</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($record['Top3ComputerSales'] as $data)
							<tr>
								<td class="td">{{ $data['SLNo'] }}</td>
								<td class="td">{{ $data['PCName'] }}</td>
								<td class="td">K{{ number_format((float)$data['Total'], 2) }}</td>
							</tr> 
							@endforeach
							<tr>
								<td colspan="2" class="td">Total</td> 
								<td class="td">K{{ number_format(collect($record['Top3ComputerSales'])->sum('Total'), 2) }}</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>

	</div>

	</div>
</body>

</html>