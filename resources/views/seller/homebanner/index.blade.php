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
            <h1>Home Banner List</h1>
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
                <a href="{{ route('homebanner.create') }}" class="btn btn-primary">Add Home Banner</a>
              </div>
              <div class="card-body">
				@if(isset($HomeBanner) && !empty($HomeBanner))
                <table id="example1" class="table table-bordered table-striped w-100">
                  <thead>
                    <tr>
                      <th>Banner</th>
                      <th>URL</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($HomeBanner as $val)
                        <tr>
                          <td><img src="{{ getImage($val->image) }}" style="height: 100px; width: -webkit-fill-available; object-fit: contain;" /></td>
                          <td>{{ $val->redirect_url }}</td>
                          <td>{{ (isset($val->status) && !empty($val->status)) ? ucfirst($val->status) : '' }}</td>
							  <td>
								<div class="d-flex">
								  <a href="{{ route('homebanner.edit',$val->id) }}" class="btn btn-primary tableActionBtn editBtn" title="Edit Banner"><i class="right fas fa-edit"></i></a>
								  <form action="{{ route('homebanner.destroy', $val->id) }}" id="deleteForm" method="POST">
									@csrf
									@method('DELETE')
									<a class="btn btn-danger tableActionBtn deleteBtn" title="Delete Banner"><i class="right fas fa-trash"></i></a>
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
        html: "If you will delete this Banner?",
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