
	<style>
		
/* ============= mobile navigation ========================== */
.home-menu-icon-container {
	display: none;
	width: -webkit-fill-available;
    position: fixed;
    bottom: 0;
    z-index: 9999;
    background: #fff;
    border-top: 1px solid #f1f1f1;
	box-shadow: 0px -1px 5px var(--primary);
	margin: 0px 8px 5px 8px;
    border-radius: 18px;
}
.mobile-icon-section {
    display: flex;
    justify-content: space-around;
}
.home-menu-icon-container a {
    font-size: 10px;
    color: #2d2c2c;
    padding: 5px 10px;
    display: flex;
    align-items: center;
    flex-direction: column;
}
.home-menu-icon-container .active {
    /* box-shadow: 0px 0px 5px var(--primary); */
    color: var(--primary);
    /* border-radius: 10px; */
}

.home-menu-icon-container a i {
    font-size: 20px;
}
@media (max-width: 767px){	
	.home-menu-icon-container {
		display: block;
	}
}

	</style>
	
	<div class="home-menu-icon-container">
		<div class="mobile-icon-section pt-1 pb-1 pr-2 pl-2">
			<a href="{{ url('/') }}" class="{{ (request()->is('Home') || request()->is('/')) ? 'active' : '' }}" aria-label="Home"><i class="fas fa-home"></i><span> Home</span></a>
			<a href="{{ url('/products') }}" class="{{ (request()->is('products')) ? 'active' : '' }}" aria-label="Shop"><i class="fas fa-store-alt" ></i><span> Shop</span></a>
			<!-- <a href="{{ url('/collections') }}" class="{{ (request()->is('collections')) ? 'active' : '' }}" aria-label="Collections"><i class="fas fa-list-ul" style="font-size:25px"></i><span> Collections</span></a> -->
			@if(Auth::check())
				<a href="{{ route('account.order') }}" class="{{ (request()->is('account/order')) ? 'active' : '' }}" aria-label="account"><i class="fa-solid fa-box" ></i><span> Orders</span></a>
				<a href="{{ url('/account') }}" class="{{ (request()->is('account')) ? 'active' : '' }}" aria-label="account"><i class="fa-solid fa-user" ></i><span> Account</span></a>
			@else
				<a href="#" data-toggle="modal" data-target="#authmodal" aria-label="account"><i class="fa-solid fa-user" style="font-size:25px"></i><span> Login</span></a>
			@endif
		</div>
	</div>