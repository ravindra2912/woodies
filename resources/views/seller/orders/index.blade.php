@extends('seller.layouts.index')

@section('custom_css')

  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <style>
	
	.bulk-action{
		display:none;
	}
	.statuses{
	}
	.statuses label{
		border: 1px solid var(--primary);
		padding: 0px 5px;
		border-radius: 5px;
		color: var(--primary);
		font-size: 14px;
	}
	.statuses label:hover, input[type="radio"]:checked + label{
		color: white;
		background: var(--primary);
	}
	input[type="radio"]{
		opacity: 0;
		position: absolute;
	}
	.pa{
		color: black;
	}
	
	@media only screen and (max-width: 600px) {
		.statuses::-webkit-scrollbar {
		  display:none;
		  width:0px;
		}
		
		.statuses{
		margin: -19px 0px 0px 0px;	
		display: flex;
		//width:50%;
		overflow: auto;
	}
	.statuses label{
		margin-right: 5px;
		white-space: nowrap;
	}
	}
  </style>
@endsection

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Orders List</h1>
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
				<form action="{{ route('Order.index') }}" id="filter" method="get" enctype="multipart/form-data"> 
					<div class="row filter-div">
					<div class="statuses mb-2 col-12">
						<input type="radio" name="status" value="" id="staAll" onchange="$('#filter').submit()" {{ ($request->status == '') ? 'checked':'' }}  />
							<label for="staAll">All</label>
						@foreach($orderstaus as $os)
							<input type="radio" name="status" value="{{ $os->id }}" id="sta{{ $os->id }}" onchange="$('#filter').submit()" {{ ($request->status == $os->id) ? 'checked':'' }}  />
							<label for="sta{{ $os->id }}">{{ $os->name }} ({{ $os->orders }})</label>
						@endforeach
					</div>
						<div class="col-sm-1">
						</div>
						<div class="col-sm-2 col-6">
							<div class="form-group">
							<label>From Date</label>
								<input type="date" name="start_date" value="{{$request['start_date']}}" class="form-control"  >
							</div>
						</div>												
						
						<div class="col-sm-2 col-6">
							<div class="form-group">
							<label>To Date</label>
								<input type="date" name="end_date" value="{{$request['end_date']}}" class="form-control"  >
							</div>
						</div>		

						<div class="col-sm-2 col-6">            
							<div class="form-group">       
								<label for="category">Payment Status</label>     
								<select class="form-control" name="payment_status" id="payment_status">	
									<option value="" >All </option>	
									<option value="0" {{ ($request->payment_status == '0') ? 'selected':'' }}> PENDING </option>	
									<option value="1" {{ ($request->payment_status == 1) ? 'selected':'' }}> SUCCESS </option>	
									<option value="2" {{ ($request->payment_status == 2) ? 'selected':'' }}> FAIL </option>	
									<option value="3" {{ ($request->payment_status == 3) ? 'selected':'' }}> Refund </option>	
								</select>   
                   			</div>   
						</div>
						
						<div class="col-sm-2 col-6">            
							<div class="form-group">       
								<label for="category">Payment Type</label>     
								<select class="form-control" name="payment_type" id="payment_type">	
									<option value="">All </option>	
									<option value="1" {{ ($request->payment_type == 1) ? 'selected':'' }}> Online </option>	
									<option value="2" {{ ($request->payment_type == 2) ? 'selected':'' }}> COD </option>	
								</select>   
                   			</div>   
						</div>	
						
						<div class="col-sm-2 col-6">
							<div class="form-group">
							<label for="bundle_name">Search</label>
								<input type="search" name="search" value="{{$request['search']}}" class="form-control" placeholder="Search" >
							</div>
						</div>	
						<div class="col-sm-1 col-12 pt-3 align-self-center">		
							<div class="">
								<button class="btn btn-primary" name="action" value="submit" title="Search" type="submit" ><i class="fas fa-search"></i></button>				
								<button class="btn btn-primary" name="action" value="export" title="Export Order" type="submit" ><i class="fas fa-file-excel"></i></button>				
							</div>						
						</div>
					</div>
               </form>
			  
			  <div class=" bulk-action">
				  <div class="row ">
						<div class="col-sm-2">            
							<div class="form-group">       
								<label for="category">Bulk Action </label>     
								<select class="form-control" name="bulk_status" id="bulk_status">	
									<option value="">Select Status </option>	
									@foreach($orderstaus as $os)
										<option value="{{ $os->id }}">{{ $os->name }} </option>	
									@endforeach					
								</select>   
							</div>   
						</div>
						<div class="col-sm-2 mt-4 pt-2">
							<button type="button" class="btn btn-primary btn-round bulk-btn">Submit</button>
						</div>
					</div>
				</div>
              </div>
            </div>
          </div>
		  
		  <div class="col-12">
			<div class="card table-card">
			  <div class="card-body">
				@if(isset($orderLists) && !empty($orderLists) && count($orderLists) > 0)
					<div style="overflow: auto;" class="m-hide">
						<table id="example1" class="table table-striped w-100">
						  <thead>
							<tr>
								@if($request->status != '')
									<th> <input type="checkbox" id="bulk_all"  /> </th>
								@endif
								<th>Sr. No </th>
								<th>User</th>
								<th>Contact</th>
								<th>Amount</th>
								<th>Order Date</th>
								<th class="text-center">Status</th>
								<th class="text-center">Payment Status</th>
								<th class="text-center">Payment Type</th>
								<th>Action</th>
							</tr>
						  </thead>
						  <tbody>
							@php $i=1; @endphp
							@if(isset($orderLists) && !empty($orderLists))
							  @foreach($orderLists as $ordertList)
								@php
									$status = (isset($ordertList->order_status) && !empty($ordertList->order_status)) ? $ordertList->order_status->name :'';
									$status_style = (isset($ordertList->order_status) && !empty($ordertList->order_status)) ? $ordertList->order_status->badge_style :'';
								@endphp
								<tr>
									@if($request->status != '')
										 <td><input type="checkbox" class="check" name="bulk_action[]" value="{{ $ordertList->id }}" /></td>
									@endif
									<td> {{ $i++ }}  </td>
									<td>{{ (isset($ordertList->user_data) && !empty($ordertList->user_data))?ucfirst($ordertList->user_data->first_name) :''}}</td>
									<td>{{ $ordertList->contact }}</td>
									<td>Rs. {{ $ordertList->total }}</td>
									<td>{{ get_date($ordertList->created_at) }}</td>
									<td class="text-center"><div class="{{ $status_style }}" >{{ $status }}</div></td>
									<td class="text-center">
										@if($ordertList->payment_status == 1)
											<span class="badge badge-success">SUCCESS</span>
										@elseif($ordertList->payment_status == 2)
											<span class="badge badge-danger">FAIL</span>
										@elseif($ordertList->payment_status == 3)
											<span class="badge badge-info">Refund</span>
										@else
											<span class="badge badge-warning">PENDING</span>
										@endif
									</td>
									<td class="text-center">
										@if($ordertList->payment_type == 1)
											<span class="badge badge-success">Online</span>
										@elseif($ordertList->payment_type == 2)
											<span class="badge badge-info">COD</span>
										@endif
									</td>
								  <td>
									<div class="d-flex justify-content-center">
									  <a href="{{ url('/pdf_invoice/'.$ordertList->id) }}" class="btn btn-primary tableActionBtn editBtn mr-1" title="Download PDF"><i class="right fas fa-file-pdf"></i></a>
									  <a href="{{ route('Order.edit',$ordertList->id) }}" class="btn btn-primary tableActionBtn editBtn" title="View Order"><i class="right fas fa-eye"></i></a>
									</div>
								  </td>
								</tr>
							  @endforeach
							@endif
						  </tbody>
						</table>
						
					  </div>
					  
					  
					  
					<div class="m-show p-2">
						@if(isset($orderLists) && !empty($orderLists))
							  @foreach($orderLists as $ordertList)
								@php
									$status = (isset($ordertList->order_status) && !empty($ordertList->order_status)) ? $ordertList->order_status->name :'';
									$status_style = (isset($ordertList->order_status) && !empty($ordertList->order_status)) ? $ordertList->order_status->badge_style :'';
								@endphp
									<div class="text-right text-muted">{{ get_date($ordertList->created_at) }}</div>
									<a href="{{ route('Order.edit',$ordertList->id) }}" class="card pa" >
										<div class="card-header py-1 ">
											<div class="mb-0 float-left">#{{ $ordertList->id }}</div>
											<div class="mb-0 float-right"><div class="{{ $status_style }}" >{{ $status }}</div></div>
										</div>
										<div class="card-body">
											<div class="row m-2">
												<div class="col-7">
													<h6 class="font-weight-bold">{{ (isset($ordertList->user_data) && !empty($ordertList->user_data))?ucfirst($ordertList->user_data->first_name) :''}}</h6>
													<p>{{ $ordertList->contact }}<p>
												</div>
												<div class="col-5">
													<h4>${{ $ordertList->total }}</h4>
												</div>
												<div class="col-12 row pt-1 ml-0" style="border-top: 1px solid grey;">
													<div class="col-6 text-center" style="border-right: 1px solid grey;">
														<p class="mb-1">Payment Status</p>
														@if($ordertList->payment_status == 1)
															<span class="badge badge-success">SUCCESS</span>
														@elseif($ordertList->payment_status == 2)
															<span class="badge badge-danger">FAIL</span>
														@elseif($ordertList->payment_status == 3)
															<span class="badge badge-info">Refund</span>
														@else
															<span class="badge badge-warning">PENDING</span>
														@endif
													</div>
													<div class="col-6 text-center">
														<p class="mb-1">Payment Type</p>
														@if($ordertList->payment_type == 1)
															<span class="badge badge-success">Online</span>
														@elseif($ordertList->payment_type == 2)
															<span class="badge badge-info">COD</span>
														@endif
													</div>
												</div>
											</div>
										</div>
									</a>
									
							@endforeach
						@endif
					</div>
					
					<div class="d-flax align-self-end mr-3" >
					{{ $orderLists->appends(request()->except('page'))->links() }}
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