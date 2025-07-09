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
            <h1>Product Review List</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
				<form action="{{ route('product.product_review', $id) }}" method="get" enctype="multipart/form-data" > 
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
						<div class="col-sm-3">
							<div class="form-group">
							<label for="bundle_name">Search</label>
								<input type="search" name="search" value="{{$request['search']}}" class="form-control" placeholder="Search" >
							</div>
						</div>	
						<div class="col-sm-2">		
							<div class="form-group">
								<label for="bundle_name" style="margin-top: 35px;">&nbsp;</label>
								<button class="btn btn-primary" name="action" value="submit" title="Search" type="submit" >Search</button>				
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
				@if(isset($ProductReview) && !empty($ProductReview) && count($ProductReview) > 0)
					<table id="example1" class="table table-striped w-100">
					  <thead>
						<tr>
						  <th>Sr. No</th>
						  <th>Name</th>
						  <th>Email</th>
						  <th>Rating</th>
						  <th>Reviev</th>
						  
						</tr>
					  </thead>
					  <tbody>
						@php $i=1; @endphp
						  @foreach($ProductReview as $val)
							<tr>
							  <td>{{ $i++ }}</td>
							  <td>{{ (isset($val->reviewer_name) && !empty($val->reviewer_name)) ? ucfirst($val->reviewer_name) : '' }}</td>
							  <td>{{ (isset($val->email) && !empty($val->email)) ? ucfirst($val->email) : '' }}</td>
							  <td>{{ (isset($val->rating) && !empty($val->rating)) ? ucfirst($val->rating) : '' }}</td>
							  <td>{{ (isset($val->review) && !empty($val->review)) ? ucfirst($val->review) : '' }}</td>
							  <!-- td>
								<div class="d-flex">
									<a href="{{ route('product.edit',$val->id) }}" class="btn btn-primary tableActionBtn editBtn" title="Edit Product"><i class="right fas fa-edit"></i></a>
									
									<form action="{{ route('product.destroy', $val->id) }}" id="deleteForm" method="POST">
										@csrf
										@method('DELETE')
										<a class="btn btn-danger tableActionBtn deleteBtn" title="Delete Product"><i class="right fas fa-trash"></i></a>
									</form>
								</div>
							  </td -->
							</tr>
						  @endforeach
					  </tbody>
					</table>
					<div class="d-flax align-self-end mr-3" >
						{{ $ProductReview->appends(request()->except('page'))->links() }}
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

  <script type="text/javascript">
   

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