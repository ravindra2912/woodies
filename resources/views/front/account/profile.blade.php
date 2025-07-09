@extends('front.layouts.index')

@section('seo')
		<title>Bajarang | Profile</title>
@endsection

@section('custom_css')  
<style>
	.user_profile{
		margin-top: -150px;
	}
	.user_profile img{
		height: 150px;
		width: 150px;
		object-fit: cover;
		border-radius: 100%;
		border: 3px solid var(--primary);
	}
	.user_profile p{
		margin-top: 3px;
		color: var(--primary);
		font-size: 18px;
	}
	#image{
		opacity: 0;
		//position: absolute;
	}
</style>

@endsection

@section('content')

	<section id="nevigation-header" style="background-image: url({{ asset('front/images/user-bg.png') }});">
		
	</section>
  
	<section class="mt-5 mb-5 pb-5">
		<div class="container">
			<form action="{{ route('account.update_profile')}}" id="updateform" method="post" class="row" enctype="multipart/form-data"> @csrf
				<div class="col-lg-12 col-md-12 col-12  user_profile mb-4 text-center">
					<img class="" src="{{ getImage($user->image) }}" />
					<p onclick="$('#image').click()">Change <i class="fa-solid fa-pen"></i></p>
					<input type="file" name="image" onchange="$('#updateform').submit()" id="image">
				</div>
					
				<div class="form-group col-lg-6 col-md-6 col-12">
					<input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" placeholder="Your First Name *">
				</div>
				
				<div class="form-group col-lg-6 col-md-6 col-12">
					<input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" placeholder="Your Last Name *">
				</div>
				
				<div class="form-group col-lg-6 col-md-6 col-12">
					<input type="text" name="mobile_no" class="form-control" value="{{ $user->mobile }}" placeholder="Your Contact *">
				</div>
				
				<div class="form-group col-lg-6 col-md-6 col-12">
					<input type="text" name="email" class="form-control" value="{{ $user->email }}" placeholder="Your Email *">
				</div>
				<div class="form-check col-lg-12 col-md-12 col-12 text-right">
					<button type="submit" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button">Update</button>
					<button type="button" class="btn btn-primary btn-round mt-3 ml-2 pr-4 pl-4 submit_button loading" style="display:none;">Loading ...</button>
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

