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
            <h1>Faq List</h1>
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
                  <a href="{{ route('faq.create') }}" class="btn btn-primary">Add Faq</a>
                </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped w-100">
                  <thead>
                    <tr>
                      <th>Index</th>
                      <th>question</th>
                      @if(Auth::user()->role_id == 1)
                      <th>Action</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @php $i=1; @endphp
                    @if(isset($faqs) && !empty($faqs))
                      @foreach($faqs as $faq)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $faq->question }}</td>
                         @if(Auth::user()->role_id == 1)
						              <td>
                            <div class="d-flex">
                              <a href="{{ route('faq.edit',$faq->id) }}" class="btn btn-primary tableActionBtn editBtn" title="Edit Faq"><i class="right fas fa-edit"></i></a>
                              <form action="{{ route('faq.destroy', $faq->id) }}" id="deleteForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-danger tableActionBtn deleteBtn" title="Delete Faq"><i class="right fas fa-trash"></i></a>
                              </form>
                            </div>
                          </td>
						            @endif
                        </tr>
                      @endforeach
                    @endif
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
        html: "You want to delete this faq?",
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