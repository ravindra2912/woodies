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
          <h1>testimonail List</h1>
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
              <a href="{{ route('testimonail.create') }}" class="btn btn-primary">Add Main testimonail</a>
            </div>
            <div class="card-body">
              @if(isset($list) && !empty($list) && count($list) > 0)
              <table id="example1" class="table table-bordered table-striped w-100">
                <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Img</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @php $i=1; @endphp

                  @foreach($list as $val)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td><img src="{{ getimage($val->thumbnail_image) }}" height="100px" /></td>
                    <td>{{ $val->name }}</td>
                    <td>{{ (isset($val->status) && !empty($val->status)) ? ucfirst($val->status) : '' }}</td>
                    <td>
                      <div class="d-flex">
                        <a href="{{ route('testimonail.edit',$val->id) }}" class="btn btn-primary tableActionBtn editBtn" title="Edit Main Category"><i class="right fas fa-edit"></i></a>
                        <form action="{{ route('testimonail.destroy', $val->id) }}" id="deleteForm" method="POST">
                          @csrf
                          @method('DELETE')
                          <a class="btn btn-danger tableActionBtn deleteBtn" title="Delete testimonail"><i class="right fas fa-trash"></i></a>
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
  $(function() {
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
  $(".deleteBtn").click(function() {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'error',
        html: " want to delete this testimonail?",
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