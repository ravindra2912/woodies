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
					<h3 style="margin-bottom: 0px;">Department Sales</h3>
					<table class="w-100 ">
						<tr>
							<td class="p-1" style="border: 1px solid #333; padding: 6px 8px;"> From : {{ $invoice_date }}</td>
							<td class="p-1"  style="border: 1px solid #333; padding: 6px 8px;"> To : {{ $invoice_date }}</td>
						</tr> 
					</table>
				</td>
			</tr>
			@foreach ($departments as $val)
			<tr class="data-table">
				<td>
					<h3 style="margin-bottom: 0px;"> Department : {{ $val['name'] }}</h3>
					<table>
						<thead>
							<tr>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Stock Code</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Description</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Quantity</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Cost</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">VAT</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Sales</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Profit</th>
							</tr>
						</thead>
						<tbody>
							@php
							$total_Quantity = 0;
							$total_Cost = 0;
							$total_VAT = 0;
							$total_Sales = 0;
							$total_Profit = 0;
							@endphp
							@foreach ($val['data'] as $data)
							@php
							$total_Quantity += $data['Quantity'];
							$total_Cost += $data['Cost'];
							$total_VAT += $data['VAT'];
							$total_Sales += $data['Sales'];
							$total_Profit += $data['Profit'];
							@endphp

							<tr>
								<td style="border: 1px solid #bcb6b6;">{{ $data['Code'] }}</td>
								<td style="border: 1px solid #bcb6b6;">{{ $data['Description'] }}</td>
								<td style="border: 1px solid #bcb6b6;">{{ number_format((float)$data['Quantity'], 3) }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$data['Cost'], 2) }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$data['VAT'], 2) }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$data['Sales'], 2) }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$data['Profit'], 2) }}</td>
							</tr>
							@endforeach
							<tr>
								<td style="border: 1px solid #bcb6b6;">
									<h3 style="margin-top: 0px;">Total:</h3>
								</td>
								<td style="border: 1px solid #bcb6b6;"></td>
								<td style="border: 1px solid #bcb6b6;">{{ number_format((float)$total_Quantity, 3) }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$total_Cost, 2) }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$total_VAT, 2) }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$total_Sales, 2) }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$total_Profit, 2) }}</td>

							</tr>

						</tbody>
					</table>
				</td>
			</tr>
			@endforeach

		</table>

	</div>

	</div>
</body>

</html>