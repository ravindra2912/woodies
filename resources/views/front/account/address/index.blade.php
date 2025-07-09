@extends('front.layouts.index')

@section('seo')
		<title>Bajarang | Addresses</title>
@endsection

@section('custom_css')  
<!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
	th, td{
		text-align: center;
	}
</style>

@endsection

@section('content')

	<!-- section id="nevigation-header">
		<h3>Add To Cart</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> Add To Cart</p>
	</section -->
  
	<section class="mt-5 mb-5 pb-5">
		<div class="container" style="overflow: auto;">
			@if(isset($Address) && !empty($Address))
				
				
				<div class="row">
					<div class="col-md-12 mb-4">
						<p class="h4 font-wieght-bold float-left" > Your Address</p>
						<div class="btn btn-primary float-right" data-toggle="modal" data-target="#addaddressmodal"><i class="fa-solid fa-plus"></i></div>
					</div>
					@foreach($Address as $val)
					<div class="col-md-4 mb-3">
						<div class="card">
							<div class="card-header"> 
								{{ $val->name }} 
								<div class="btn btn-primary btn-sm float-right deleteBtn" data-id="{{ $val->id }}" data-action="{{ route('address.remove_address') }}" ><i class="fa-solid fa-trash-can"></i></div>
								<div class="btn btn-primary btn-sm float-right mr-1" data-toggle="modal" data-target="#editaddressmodal{{ $val->id }}"><i class="fa-solid fa-pen-to-square"></i></div>
								
							</div>
							<div class="card-body">
								<p>
									{{ $val->address }}<br>
									{{ $val->address2 }}<br>
									{{ $val->country.', '.$val->state.', '.$val->city.', '.$val->zipcode }}
								</p>
								<p>{{ $val->contact }}</p>
							</div>
						</div>
					</div>
					
					<!--Eddit Moddels -->
					<div class="modal fade" id="editaddressmodal{{ $val->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-md" role="document">
							<div class="modal-content">
								
								<div class="modal-body">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<p class="h4 mb-3 font-weight-bold">Update Address</p>
									<form action="{{ route('address.add_update') }}" class="addressform"  class="row">{{ csrf_field() }}
										<input type="hidden" name="address_id" value="{{ $val->id }}" />
										<div class="form-group col-lg-12 col-md-12 col-12">
											<input type="text" name="name" class="form-control" value="{{ $val->name }}" placeholder="Your Name *">
										</div>
										
										<div class="form-group col-lg-12 col-md-12 col-12">
											<input type="number" name="contact" class="form-control" value="{{ $val->contact }}" placeholder="Your Contact Number *">
										</div>
										
										<div class="form-group col-lg-12 col-md-12 col-12">
											<input type="text" name="Address" class="form-control" value="{{ $val->address }}" placeholder="Your address *">
										</div>
										
										<div class="form-group col-lg-12 col-md-12 col-12">
											<input type="text" name="address2" class="form-control" value="{{ $val->address2 }}" placeholder="Your address2 *">
										</div>
										
										<div class="form-group col-lg-12 col-md-12 col-12">
											<input type="text" name="country" class="form-control" value="{{ $val->country }}" placeholder="Your Country *">
										</div>
										
										<div class="form-group col-lg-12 col-md-12 col-12">
											<input type="text" name="state" class="form-control" value="{{ $val->state }}" placeholder="Your State *">
										</div>
										
										<div class="form-group col-lg-12 col-md-12 col-12">
											<input type="text" name="city" class="form-control" value="{{ $val->city }}" placeholder="Your City *">
										</div>
										
										<div class="form-group col-lg-12 col-md-12 col-12">
											<input type="text" name="zipcode" class="form-control" value="{{ $val->zipcode }}" placeholder="Your ZipCode *">
										</div>
										
										
										
										<div class="form-check col-lg-12 col-md-12 col-12 text-right">
											<button type="submit" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button">Update</button>
											<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button loading" style="display:none;">Loading ...</button>
										</div>
									</form>
								</div>
								<!-- div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								</div -->
							</div>
						</div>
					</div>
					
					@endforeach
				</div>	
					
				<div class="d-flax " >
					{{ $Address->appends(request()->except('page'))->links() }}
				</div>
				
			@else
				<div class="text-center">
					<p class="h4 font-wieght-bold mt-5" > Your Address is empty</p>
				</div>
			@endif
			
			
		</div>
	</section>
	
	<div class="modal fade" id="addaddressmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">
				
				<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<p class="h4 mb-3 font-weight-bold">Add New Address</p>
					<form action="{{ route('address.add_update') }}" class="addressform" class="row">{{ csrf_field() }}
						
						<div class="form-group col-lg-12 col-md-12 col-12">
							<input type="text" name="name" class="form-control" placeholder="Your Name *">
						</div>
						
						<div class="form-group col-lg-12 col-md-12 col-12">
							<input type="number" name="contact" class="form-control" placeholder="Your Contact Number *">
						</div>
						
						<div class="form-group col-lg-12 col-md-12 col-12">
							<input type="text" name="Address" class="form-control" placeholder="Your address *">
						</div>
						
						<div class="form-group col-lg-12 col-md-12 col-12">
							<input type="text" name="address2" class="form-control" placeholder="Your address2 *">
						</div>
						
						<div class="form-group col-lg-12 col-md-12 col-12">
							<input type="text" name="country" class="form-control" placeholder="Your Country *">
						</div>
						
						<div class="form-group col-lg-12 col-md-12 col-12">
							<input type="text" name="state" class="form-control" placeholder="Your State *">
						</div>
						
						<div class="form-group col-lg-12 col-md-12 col-12">
							<input type="text" name="city" class="form-control" placeholder="Your City *">
						</div>
						
						<div class="form-group col-lg-12 col-md-12 col-12">
							<input type="text" name="zipcode" class="form-control" placeholder="Your ZipCode *">
						</div>
						
						
						
						<div class="form-check col-lg-12 col-md-12 col-12 text-right">
							<button type="submit" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button">Add</button>
							<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button loading" style="display:none;">Loading ...</button>
						</div>
					</form>
				</div>
				<!-- div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div -->
			</div>
		</div>
	</div>
	
@endsection

@section('custom_js')  
<script>	
	$(".addressform").on('submit',(function(e) {
		  e.preventDefault();
			var form = this;
			  $.ajax({
				url: this.action,
				type: "POST",
				data:  new FormData(this),
				dataType: "json",
				headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
				contentType: false,
				cache: false,
				processData:false,
				beforeSend : function(){ 
					$('.submit_button').hide();
					$('.loading').show();
				},
				success: function(result){
					//console.log(data);
					
					if(result.success){
					  toastr.success(result.message);
					  location.reload();
					}
					else{
						if(!result.auth){
							location.reload();
						}else{
							toastr.error(result.message);
						}
						
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e){ 
					console.log(e);
					var e = eval("(" + e.responseText + ")");
					if(e.message == "CSRF token mismatch."){ 
						toastr.error('Your session has expired');
						setTimeout(function() { location.reload(); }, 3000);
					}else{
						toastr.error('Something Wrong');
					}
				}           
			});
		}));
		
		// Display sweet alert while deleting
			$(".deleteBtn").click(function(){
				var address_id = $(this).data('id');
				var action = $(this).data('action');
			  Swal.fire({
				title: 'Are you sure?',
				icon: 'error',
				html: "You want to delete this Address?",
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonText: 'Delete',
				cancelButtonText: 'Cancel',
			  })
			  .then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: action,
						type: "POST",
						data:  {
							'address_id':address_id,
						},
						dataType: "json",
						headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
						beforeSend : function(){ 
						},
						success: function(result){
							//console.log(data);
							
							if(result.success){
							  toastr.success(result.message);
							  location.reload();
							}
							else{
								if(!result.auth){
									location.reload();
								}else{
									toastr.error(result.message);
								}
								
							}
							$('.submit_button').show();
							$('.loading').hide();
						},
						error: function(e){ 
							console.log(e);
							var e = eval("(" + e.responseText + ")");
							if(e.message == "CSRF token mismatch."){ 
								toastr.error('Your session has expired');
								setTimeout(function() { location.reload(); }, 3000);
							}else{
								toastr.error('Something Wrong');
							}
						}           
					});
				}
			  })
			});
</script>	

@endsection

