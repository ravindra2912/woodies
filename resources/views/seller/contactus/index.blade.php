@extends('seller.layouts.index')

@section('custom_css')

  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contact List</h1>
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
				<form action="{{ route('contactus.index') }}" method="get" enctype="multipart/form-data" > 
					<div class="row filter-div">
						<div class="col-sm-3">
						</div>
						<div class="col-sm-2">
							<div class="form-group">
							<label>From Date</label>
								<input type="date" name="start_date" value="{{$request['start_date']}}" class="form-control"  >
							</div>
						</div>												
						
						<div class="col-sm-2">
							<div class="form-group">
							<label>To Date</label>
								<input type="date" name="end_date" value="{{$request['end_date']}}" class="form-control"  >
							</div>
						</div>		

						<!-- div class="col-sm-2">            
							<div class="form-group">       
								<label for="category">Status</label>     
								<select class="form-control" name="status" id="status">	
									<option value="">All </option>	
													
								</select>   
                   			</div>   
						</div -->	
						
						<div class="col-sm-3">
							<div class="form-group">
							<label for="bundle_name">Search</label>
								<input type="search" name="search" value="{{$request['search']}}" class="form-control" placeholder="Search" >
							</div>
						</div>	
						<div class="col-sm-2">		
							<div class="form-group">
								<label for="bundle_name" style="margin-top: 35px;">&nbsp;</label>
								<button class="btn btn-primary" name="action" value="submit" type="submit" >Search</button>					
							</div>						
						</div>						
					</div>					
               </form>
              </div>
            </div>
          </div>
		  
		  <div class="col-12">
            <div class="card table-card">
              <div class="card-body">
				@if(isset($ContactUs) && !empty($ContactUs))
                <table id="example1" class="table table-striped w-100">
                  <thead>
                    <tr>
                      <th>Sr. No</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>messege</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $i=1; @endphp
                    
                      @foreach($ContactUs as $val)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $val->name }}</td>
                          <td>{{ $val->phone }}</td>
                          <td>{{ $val->email }}</td>
                          <td>{{ $val->type }}</td>
                          <td>{{ $val->messege }}</td>
                          <td>{{ date_format(date_create($val->created_at), 'd-m-Y h:i:s a') }}</td>
                          <!-- td>
                            <div class="d-flex">
                              <a href="{{ route('Order.edit',$val->id) }}" class="btn btn-primary tableActionBtn editBtn" title="View Order"><i class="right fas fa-eye"></i></a>
                              
                            </div>
                          </td -->
                        </tr>
                      @endforeach
                  </tbody>
                </table>
				<div class="d-flax align-self-end mr-3" >
					{{ $ContactUs->appends(request()->except('page'))->links() }}
				</div>
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
   /* $(function () {
      $("#example1").DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    }); */

    // Display sweet alert while deleting
    $(".deleteBtn").click(function(){
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
          $(this).closest("form").submit();
        }
      })
    });
  </script>
@endsection