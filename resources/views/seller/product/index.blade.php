@extends('seller.layouts.index')

@section('custom_css')

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables CSS -->
<link href="{{ asset('admin_theme/DataTables/datatables.min.css') }}" rel="stylesheet">

<style>
	.filter input,
	.filter select {
		width: max-content;
		margin-right: 5px;
	}
</style>
@endsection

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Product List</h1>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					@include('seller/layouts/alerts')
					<div class="card">
						<div class="card-header">
							<a href="{{ route('product.create') }}" title="Add New Product" class="btn btn-success btn-sm float-right">+ Add new product</a>
							<!-- <button href="{{ route('product.create') }}" title="Import Product" class="btn btn-success btn-sm float-right mr-2" data-toggle="modal" data-target="#modal-import">Import</button> -->
						</div>
						<div class="card-body">
							<div class="row filter mb-3 ">
								<select class="form-control" name="status" id="status">
									<option value="">All </option>
									<option value="Active">Active </option>
									<option value="Inactive">Inactive </option>
								</select>
							</div>

							<table id="example1" class="table table-striped w-100">
								<thead>
									<tr >
										<th>#</th>
										<th>Product Name</th>
										<th>Price</th>
										<th>Category Name</th>
										<th>Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<div class="modal fade" id="modal-import">
	<div class="modal-dialog">
		<form action="{{ route('product.import') }}" id="importform" method="post" enctype="multipart/form-data" class="modal-content">@csrf
			<div class="modal-header">
				<h4 class="modal-title">Import Product</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<label>File</label>
				<input type="file" name="file" class="form-control" />
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<a href="{{ asset('uploads/bulk upload demo.xlsx') }}" download class="btn btn-info">Download Demo</a>
				<button type="submit" class="btn btn-primary btn_action">Submit</button>
				<button type="button" class="btn btn-primary loading" style="display:none;">Loading ...</button>
			</div>
		</form>
	</div>
</div>
@endsection

@section('custom_js')
<!-- DataTables -->
<script src="{{ asset('admin_theme/DataTables/datatables.min.js') }}"></script>

<script type="text/javascript">
	$(function() {
		var table = $('#example1').DataTable({
			processing: true,
			serverSide: true,
			responsive: true,
			// ajax: "",
			ajax: {
				url: "{{ route('product.index') }}",
				data: function(d) {
					d.status = $('#status').val();
				}
			},
			columns: [{
					data: 'img',
					name: 'img',
					searchable: false,
				}, {
					data: 'name',
					name: 'name',
				}, {
					data: 'price',
					name: 'price',
					render: function(data, type, row) {
						return 'Rs. ' + parseFloat(data).toFixed(2);
					}
				},
				{
					data: 'category',
					name: 'categories.name',
					orderable: false,
				}, {
					data: 'status',
					name: 'status',
					searchable: false,
					orderable: false,
				},
				{
					data: 'action',
					name: 'action',
					orderable: false,
					searchable: false
				},
			],
			initComplete: function() {
				// Move the status filter beside the search box
				$("#status")
					.appendTo("#example1_length")
					.show()
					.css({
						display: "inline-block",
						width: "auto",
						marginLeft: '5px'
					});
			},
			drawCallback: function() {
				// Scroll to the first row
				$('html, body').animate({
					scrollTop: $('#example1').offset().top - 100 // optional offset
				}, 300);
			}
		});

		$('#status').on('change', function() {
			table.ajax.reload()
		})
	})

	// Display sweet alert while deleting
	function deleteProduct(id) {
		Swal.fire({
				title: 'Are you sure?',
				icon: 'error',
				html: "You want to delete this product?",
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonText: 'Delete',
				cancelButtonText: 'Cancel',
			})
			.then((result) => {
				if (result.isConfirmed) {
					$('#deleteForm' + id).submit();
				}
			})
	}
	

	$("#importform").on('submit', (function(e) {
		e.preventDefault();

		$.ajax({
			url: this.action,
			type: "POST",
			data: new FormData(this),
			dataType: "json",
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function() {
				$('.btn_action').hide();
				$('.loading').show();
			},
			success: function(result) {
				//console.log(data);

				if (result.success) {
					toastr.success(result.message);
					setTimeout(function() {
						location.reload();
					}, 1000);
				} else {
					toastr.error(result.message);
					$('.btn_action').show();
					$('.loading').hide();
				}
			},
			error: function(e) {
				toastr.error('Somthing Wrong');
				console.log(e);
				$('.btn_action').show();
				$('.loading').hide();
			}
		});
	}));
</script>
@endsection