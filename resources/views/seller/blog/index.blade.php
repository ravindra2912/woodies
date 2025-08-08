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
          <h1>Blog List</h1>
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
              <a href="{{ route('blog.create') }}" title="Add New Blog" class="btn btn-success btn-sm float-right">+ Add new Blog</a>
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
                  <tr>
                    <th>#</th>
                    <th>Title</th>
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
        url: "{{ route('blog.index') }}",
        data: function(d) {
          d.status = $('#status').val();
        }
      },
      columns: [{
          data: 'img',
          name: 'img',
          searchable: false,
        }, {
          data: 'title',
          name: 'title',
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
  function deleteBlog(id) {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'error',
        html: "You want to delete this blog?",
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
</script>
@endsection