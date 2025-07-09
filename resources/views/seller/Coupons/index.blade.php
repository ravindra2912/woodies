@extends('seller.layouts.index')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('admin_theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Coupons List</h1>
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
                <a href="{{ route('coupons.create') }}" class="btn btn-primary">Add Coupon</a>
              </div>
              <div class="card-body">
				@if(isset($Coupon) && !empty($Coupon))
					<table id="example1" class="table table-bordered table-striped w-100">
					  <thead>
						<tr>
						  <th>Sr. No</th>
						  <th>Coupon Code</th>
						  <th>discount</th> 
						  <th>From Date</th> 
						  <th>To Date</th> 
						  <th>Status</th>
						  <th>Action</th>
						</tr>
					  </thead>
					  <tbody>
						@php $i=1; @endphp
					   
						  @foreach($Coupon as $CouponList)
							<tr>
							  <td>{{ $i++ }}</td>
							  <td>{{ (isset($CouponList->coupon_code) && !empty($CouponList->coupon_code)) ? $CouponList->coupon_code : '' }}</td>
							  <td>@if($CouponList->coupon_type == 1){{ $CouponList->coupon_percent}} %@else{{ $CouponList->coupon_amount}} ₹ @endif</td>
							  <td>{{ date_format(date_create($CouponList->active_date.' '.$CouponList->active_time), 'd-m-Y h:i') }}</td>
							  <td>{{ date_format(date_create($CouponList->end_date.' '.$CouponList->end_time), 'd-m-Y h:i') }} </td>
							  <td>{{ (isset($CouponList->status) && !empty($CouponList->status)) ? ucfirst($CouponList->status) : '' }}</td>
							  <td>
								<div class="d-flex">
								  <a href="{{ route('coupons.edit',$CouponList->id) }}" class="btn btn-primary tableActionBtn editBtn" title="Edit Main Category"><i class="right fas fa-edit"></i></a>
								  <form action="{{ route('coupons.destroy', $CouponList->id) }}" id="deleteForm" method="POST">
									@csrf
									@method('DELETE')
									<a class="btn btn-danger tableActionBtn deleteBtn" title="Delete Main Category"><i class="right fas fa-trash"></i></a>
								  </form>
								</div>
							  </td>
							</tr>
						  @endforeach
					  </tbody>
					</table>
				@else
					<div class="my-3">
						<h4 class="font-weight-bold text-center">No Data Found!</h4>
					</div>
				@endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('custom_js')
  <!-- DataTables -->
  <script src="{{ asset('admin_theme/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('admin_theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('admin_theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('admin_theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

  <script type="text/javascript">
    $(function () {
      $("#example1").DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });

    // Display sweet alert while deleting
    $(".deleteBtn").click(function(){
      Swal.fire({
        title: 'Are you sure?',
        icon: 'error',
        html: "Want To Delate This Coupon?",
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
      })
      .then((result) => {
        if (result.isConfirmed) {
          $(this).closest("form").submit();
        }
      })
    });
  </script>
@endsection