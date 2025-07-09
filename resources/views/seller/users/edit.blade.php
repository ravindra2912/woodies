@extends('seller.layouts.index')

@section('custom_css')
    
	<style>
		.u-img{
			height: 150px;
			width: 150px;
			object-fit: contain;
		}
	</style>
    
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
						<h1>User Details</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
				<form action="{{ route('Users.update',$User->id) }}" id="updateform" class="card card-primary" enctype="multipart/form-data">
					<div class="card-header">
						<h3 class="card-title">Edit User</h3>
					</div>
					@if(isset($User) && !empty($User))
						<input type="hidden" name="_method" value="PATCH">
						<div class="card-body row">
						
							<div class="form-group col-md-4 col-sm-6 text-center">
								<img class="u-img" src="{{ getImage($User->image) }}">
							</div>
							<div class="col-md-8 col-sm-12 row">
								<div class="form-group col-md-6 col-sm-6">
									<label class="required">Image</label>
									<input type="file" name="image" class="form-control" >
								</div>
								
								<div class="form-group col-md-6 col-sm-6">
									<label class="required">Frist Name</label>
									<input type="text" name="first_name" class="form-control" placeholder="Frist Name" value="{{ $User->first_name }}" >
								</div>
								
								<div class="form-group col-md-6 col-sm-6">
									<label class="required">Laste Name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ $User->last_name }}" >
								</div>
								
								<div class="form-group col-md-6 col-sm-6">
									<label class="required">Contact</label>
									<input type="text" name="contact" class="form-control" placeholder="Contact" value="{{ $User->mobile }}" >
								</div>
								
							</div>
							
							<div class="form-group col-md-4 col-sm-6">
								<label class="required">Email</label>
								<input type="text" name="email" class="form-control" placeholder="Email" value="{{ $User->email }}" >
							</div>
							
							<div class="form-group col-md-4 col-sm-6">
								<label class="">Password</label>
								<input type="text" name="password " class="form-control" placeholder="Password" >
							</div>
							
							
							
						</div>
						<div class="card-footer">
							<input type="submit" class="btn btn-primary btn_action submit_button" value="Submit">
							<a href="{{ route('product.index') }}" class="btn btn-secondary btn_action">Cancel</a>
							<a href="javascript:;" class="btn btn-primary loading" style="display:none;">Edit....</a>
						</div>
					@else
						<div class="card-body">
							<p class="text-danger">No Data Found</p>
						</div>
					@endif
				</form>
                    
            </div>
        </section>
    </div>
@endsection

@section('custom_js')
    <script type="text/javascript">

        $("#updateform").on('submit',(function(e) {
			e.preventDefault();
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
					  setTimeout(function(){window.location.href = '{{ url()->previous() }}'; }, 1000);
					}
					else{
						toastr.error(result.message);
						$('.submit_button').show();
						$('.loading').hide();
					}
				},
				error: function(e){ 
					toastr.error('Somthing Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}           
			});
		}));
		
    </script>
@endsection