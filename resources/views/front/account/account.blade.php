@extends('front.layouts.index')

@section('seo')
		<title>Bajarang | Profile</title>
@endsection

@section('custom_css')  
<style>
	.ablack a{
		color:#000;
		border-bottom: 7px solid var(--secondary);
		padding-top: 5px;
		background: white;
		border-radius: 7px;
	}
	.uimg{
		height: 75px;
		object-fit: cover;
		width: 75px;
		border-radius: 100%;
		border: 2px solid var(--primary);
		padding: 3px;
	}
</style>

@endsection

@section('content')

	<section class="pr-3 pl-3" style="background: var(--secondary);">
			  <div class="container  ablack">
				  <div class="row">
					<div class="col-lg-12 bg-white shadow-md rounded p-2 mb-2">
					
						<div class="row">
							<div class="col-lg-4 col-4 p-3 pt-0 text-center">
								<img class="img-fluid align-top uimg" src="{{ getImage(isset(Auth::User()->image)?Auth::User()->image:'') }}"  alt="user">
							</div>
							<div class="col-lg-8 col-8 p-2 align-self-center">
								<p class="text-3 font-weight-600 mb-0">{{ (Auth::check())? Auth::User()->first_name.' '.Auth::User()->last_name : '' }}</p> 
								<p>{{ (Auth::check())? Auth::User()->email : '' }}</p>
							</div>
						</div>
					</div>

					<div class="col-lg-12 shadow-md rounded p-2 mb-2">
					
						<a href="{{ route('account.profile') }}" class="row pl-2 pr-2 pb-2 pos" >
							<div class=" col-9 pl-4">
								<p class="text-2 font-weight-bold mb-0">My Profile</p> 
								<p class="text-1 mb-0">Change Profile Details</p>
							</div>
							<div class=" col-3 text-right" style="align-self: center;">
								<i class="fas fa-chevron-right text-primary"></i>
							</div>
						</a>
						
						<a href="{{ route('account.change_password') }}" class="row pl-2 pr-2 pb-2  pos" >
							<div class=" col-9 pl-4">
								<p class="text-2 font-weight-bold mb-0">Change Password</p> 
								<p class="text-1 mb-0">Change Your Profile Password</p>
							</div>
							<div class=" col-3 text-right" style="align-self: center;">
								<i class="fas fa-chevron-right text-primary"></i>
							</div>
						</a>
						
						<!-- <a href="{{ route('account.address') }}" class="row pl-2 pr-2 pb-2  pos" >
							<div class=" col-9 pl-4">
								<p class="text-2 font-weight-bold mb-0">My Address</p> 
								<p class="text-1 mb-0">Change Your Address Details</p>
							</div>
							<div class=" col-3 text-right" style="align-self: center;">
								<i class="fas fa-chevron-right text-primary"></i>
							</div>
						</a> -->
						<a href="{{ route('account.wishlist') }}" class="row pl-2 pr-2 pb-2  pos" >
							<div class=" col-10 pl-4">
								<p class="text-2 font-weight-bold mb-0">My Wishlist</p> 
								<p class="text-1 mb-0">You Most Loved Products</p>
							</div>
							<div class=" col-2 text-right" style="align-self: center;">
								<i class="fas fa-chevron-right text-primary"></i>
							</div>
						</a>
						<a href="{{ route('account.order') }}" class="row pl-2 pr-2 pb-2  pos" >
							<div class=" col-9 pl-4">
								<p class="text-2 font-weight-bold mb-0">My Order</p> 
								<p class="text-1 mb-0">Your Order History</p>
							</div>
							<div class=" col-3 text-right" style="align-self: center;">
								<i class="fas fa-chevron-right text-primary"></i>
							</div>
						</a>
					
						
						<a  onclick="$('#logout-form').submit()" class="row pl-2 pr-2 pb-2  pos" >
							<div class=" col-9 pl-4">
								<p class="text-2 font-weight-bold mb-0">Log Out</p> 
								<p class="text-1 mb-0">Log Out</p>
							</div>
							<div class=" col-3 text-right" style="align-self: center;">
								<i class="fas fa-chevron-right text-primary"></i>
							</div>
						</a>
						<!--div class="row pl-2 pr-2 pb-2">
							<div class=" col-9 pl-4">
								<p class="text-2 font-weight-600 mb-0">Following</p> 
								<p class="text-1 mb-0">Store You Following</p>
							</div>
							<div class=" col-3 text-right" style="align-self: center;">
								<i class="fas fa-chevron-right"></i>
							</div>
						</div -->
					</div>
				  </div>
				</div>
	</section>
	
@endsection

@section('custom_js')  
<script>	
	
</script>	

@endsection

