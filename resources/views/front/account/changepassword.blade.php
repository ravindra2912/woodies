@extends('front.layouts.index')

@section('seo')
		<title>Bajarang | Change Password</title>
@endsection

@section('custom_css')  
<style>
	
</style>

@endsection

@section('content')

	<section id="nevigation-header">
		<h3>Change Password</h3>
		<p>Home <i class="fa-solid fa-angle-right"></i> My Account <i class="fa-solid fa-angle-right"></i> Change Password</p>
	</section>
  
	<section class="mt-5 mb-5 pb-5">
		<div class="container">
			<form action="{{ route('account.change_password')}}" id="updateform" method="post" class="row" enctype="multipart/form-data"> @csrf
				
					
				<div class="form-group col-lg-6 col-md-6 col-12">
					<h2 class="font-weight-bold mb-4">Change Password</h2>
					<input type="password" name="password" class="form-control" placeholder="New Password *">
					<input type="password" name="confirm_password" class="form-control mt-3" placeholder="Confirm New Password *">
					<button type="submit" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button">Update</button>
					<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button loading" style="display:none;">Loading ...</button>
				</div>
				
				
				<div class="form-check col-lg-6 col-md-6 col-12">
					<div class="shadow p-3 mb-5 bg-white rounded">
						<h4 class="font-weight-bold mb-3">Password must contain:</h4>
						<p>At least 1 upper case letter (A-Z)</p>
						<p>At least 1 number (0-9)</p>
						<p>At least 8 characters</p>
					</div>
				</div>
			</form>
			
		</div>
	</section>
	
@endsection

@section('custom_js')  
<script>	
	$("#updateform").on('submit',(function(e) {
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
					  $('.shopping-badge').html(result.cart_count);
					  $('.gotocart-btn').show();
					  location.reload();
					}
					else{
						if(!result.auth){
							$('#authmodal').modal('show');
						}else{
							toastr.error(result.message);
						}
					}
					$('.submit_button').show();
					$('.loading').hide();
				},
				error: function(e){ 
					toastr.error('Something Wrong');
					console.log(e);
					$('.submit_button').show();
					$('.loading').hide();
				}           
			});
		}));
</script>	

@endsection

