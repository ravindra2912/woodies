@extends('seller.layouts.index')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('admin_theme/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@endsection

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Log</h1>
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
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped w-100">
                  <thead>
                    <tr>
                      <th>Sr. No</th>
					  <th>Log</th>
                      <th>variant</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $i=1; @endphp
                    @if(isset($ProductInventoryLog) && !empty($ProductInventoryLog))
                      @foreach($ProductInventoryLog as $logs)
                        <tr>
							<td>{{ $i++ }}</td>
							<td>{{ (isset($logs->log) && !empty($logs->log)) ? ucfirst($logs->log) : '' }}</td>
							<td>{{ (isset($logs->variant) && !empty($logs->variant)) ? ucfirst($logs->variant) : '' }}</td>
							<td>{{ (isset($logs->created_at) && !empty($logs->created_at)) ? ucfirst($logs->created_at) : '' }}</td>
                          
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

  
@endsection