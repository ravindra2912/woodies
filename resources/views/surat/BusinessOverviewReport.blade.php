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
					<h3 style="margin-bottom: 0px;">Business Overview Report</h3>
					<table class="w-100 ">
						<tr>
							<td class="p-1" style="border: 1px solid #333; padding: 6px 8px;"> From : {{ $invoice_date }}</td>
							<td class="p-1" style="border: 1px solid #333; padding: 6px 8px;"> To : {{ $invoice_date }}</td>
						</tr>
					</table>
					<h3>Stock</h3>
				</td>
			</tr>
			@foreach ($record as $key => $val)
			<tr class="data-table">
				<td>
					<h3> {{$key}}</h3>
					<table>
						<thead>
							<tr>
								@foreach ($val as $key2 => $val2)
								<th style="background-color: black; color: white; border: 1px solid #bcb6b6; text-align:left;">{{$key2}}</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
							<tr>
								@foreach ($val as $key2 => $val2)
								<td style="border: 1px solid #bcb6b6;">{{$val2}}</td>
								@endforeach
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			@endforeach
			<tr>
				<td>
					<p><strong>Disclaimer:</strong> This email was sent from an automated email address (
						receipt@chrilantech.com ) which is not monitored.
						Please do not reply. Chrilan Technology will not be liable for any unanswered emails sent to this address.</p>

						<p>For assistance, please contact us via support@chrilantech.com or info@chrilantech.com .</p>
					</td>
			</tr>
		</table>

	</div>

	</div>
</body>

</html>