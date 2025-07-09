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
			<tr class="data-table">
				<td>
					<h3 style="margin-bottom: 0px;"> Overdue Supplier Invoices</h3>
					<table style="margin-bottom: 15px;">
						<thead>
							<tr>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">GRV No.</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Invoice No.</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Supplier</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">GRV Date</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Due Date</th>
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6;">Total</th>
							</tr>
						</thead>
						<tbody>
							@php
							$total = 0;
							@endphp
							@foreach ($record as $data)
							@php
							$total += $data['Total'];
							@endphp

							<tr>
								<td style="border: 1px solid #bcb6b6;">{{ $data['GRVNo'] }}</td>
								<td style="border: 1px solid #bcb6b6;">{{ $data['InvoiceNo'] }}</td>
								<td style="border: 1px solid #bcb6b6;">{{ $data['Supplier'] }}</td>
								<td style="border: 1px solid #bcb6b6;">{{ $data['GRVDate'] }}</td>
								<td style="border: 1px solid #bcb6b6;">{{ $data['DueDate'] }}</td>
								<td style="border: 1px solid #bcb6b6;">K{{ number_format((float)$data['Total'], 2) }}</td>
							</tr>
							@endforeach

						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="border: 1px solid #bcb6b6; padding:5px;">
					<h3 style="margin: 0px;">Total  </h3>
					<p style="margin: 0px;"> Incl Total : K{{ number_format((float)$total, 2) }}</p>
				</td>
			</tr>

		</table>

	</div>

	</div>
</body>

</html>