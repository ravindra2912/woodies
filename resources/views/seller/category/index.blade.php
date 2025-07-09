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
          <h1>Main Category List</h1>
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
              <a href="{{ route('category.create') }}" class="btn btn-primary">Add Main Category</a>
            </div>
            <div class="card-body">
              @if(isset($categoryLists) && !empty($categoryLists) && count($categoryLists) > 0)
              <table id="example1" class="table table-bordered table-striped w-100">
                <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Category Name</th>
                    <th>Parent category</th>
                    <th>Status</th>
                    @if(Auth::user()->role_id == 1)
                    <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @php $i=1; @endphp

                  @foreach($categoryLists as $categoryList)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ (isset($categoryList->name) && !empty($categoryList->name)) ? ucfirst($categoryList->name) : '' }}</td>
                    <td>{{ (isset($categoryList->parentCategory) && !empty($categoryList->parentCategory->name)) ? ucfirst($categoryList->parentCategory->name) : '' }}</td>
                    <td>{{ (isset($categoryList->status) && !empty($categoryList->status)) ? ucfirst($categoryList->status) : '' }}</td>
                    @if(Auth::user()->role_id == 1)
                    <td>
                      <div class="d-flex">
                        <a href="{{ route('category.edit',$categoryList->id) }}" class="btn btn-primary tableActionBtn editBtn" title="Edit Main Category"><i class="right fas fa-edit"></i></a>
                        <form action="{{ route('category.destroy', $categoryList->id) }}" id="deleteForm" method="POST">
                          @csrf
                          @method('DELETE')
                          <a class="btn btn-danger tableActionBtn deleteBtn" title="Delete Main Category"><i class="right fas fa-trash"></i></a>
                        </form>
                      </div>
                    </td>
                    @endif
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
        html: "If you will delete this category then related subcategory will be deleted too. So are you want to delete this category?",
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