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
            <h1>User List</h1>
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
				<form action="{{ route('Users.index') }}" id="filter" method="get" enctype="multipart/form-data"> 
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
				@if(isset($User) && !empty($User) && count($User) > 0)
					<table  class="table table-striped w-100">
					  <thead>
						<tr>
							<th>Sr. No </th>
							<th>Name</th>
							<th>Contact</th>
							<th>Create On</th>
							<th>Action</th>
						</tr>
					  </thead>
					  <tbody>
						@php $i=1; @endphp
						
						  @foreach($User as $val)
							<tr>
								
							  <td> {{ $i++ }}  </td>
							  <td> {{ $val->first_name.' '.$val->last_name }}  </td>
							  <td> {{ $val->mobile }}  </td>
							  <td>{{ date_format(date_create($val->created_at), 'd-m-Y h:i:s a') }}</td>
							  <td>
								<div class="d-flex justify-content-center">
								  <a href="{{ route('Users.edit',$val->id) }}" class="btn btn-primary tableActionBtn editBtn" title="View User"><i class="right fas fa-eye"></i></a>
								</div>
							  </td>
							</tr>
						  @endforeach
					  </tbody>
					</table>
					<div class="d-flax align-self-end mr-3" >
						{{ $User->appends(request()->except('page'))->links() }}
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
  

  <script type="text/javascript">
	  $('#bulk_all').on('click', function(){
			var el = $('.check');
			for(var i = 0; i <= el.length - 1; i ++){
				el[i].checked = this.checked;
				//console.log(el[i].checked);
			}
			
			if(this.checked){
				$('.bulk-action').show();
			}else{
				$('.bulk-action').hide();
			}
		})
	  
		$('.check').on('change', function(){
			var show = false;
			var el = $('.check');
			for(var i = 0; i <= el.length - 1; i ++){
				if(el[i].checked){ show = true; }
			}
			if(show){
				$('.bulk-action').show();
			}else{
				$('.bulk-action').hide();
			}
		})
		
	$('.bulk-btn').on('click',function(){
		var bulk_status = $('#bulk_status').val();
		var orders = '';
		var el = $('.check');
		for(var i = 0; i <= el.length - 1; i ++){
			if(el[i].checked){ 
				if(i == el.length - 1){
					orders += $(el[i]).val();
				}else{
					orders += $(el[i]).val()+', ';
				}
			}
		}
		
		if(bulk_status == ''){
			toastr.error('Please Select Bulk Action Status');
		}else if(orders == ''){
			toastr.error('Please Select Order');
		}else{
			$.ajax({
				type: "POST",
				url: " {{ route('Order.order_bulk_action') }}",
				dataType: "json",
				headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
				data : {
					'bulk_status': bulk_status,
					'orders': orders,
				},
				success: function(result){
					if(result.success){
						toastr.success(result.message);
						location.reload();
					}
					else{
						toastr.error(result.message);
					}
				},
				error: function(e){
					console.log(e);
				}
			});
		}
	})
		
	  
		

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