<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\LagelPagesController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// Login
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login-submit', [App\Http\Controllers\Auth\LoginController::class, 'login_submit'])->name('login-submit');
Route::post('user/register', [App\Http\Controllers\Auth\LoginController::class, 'register'])->name('user.register');
Route::post('/forgot', [App\Http\Controllers\Api\AuthController::class, 'ForgotPassword'])->name('forgot');
Route::post('/reset_password', [App\Http\Controllers\Api\AuthController::class, 'ResetPassword'])->name('reset_password');

// front
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('Products');
Route::post('/products/render_product_list', [App\Http\Controllers\ProductController::class, 'render_product_list'])->name('Products.render_product_list');
Route::post('/products/submit_review', [App\Http\Controllers\ProductController::class, 'store_review'])->name('Products.submit_review');
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'product_details']);
Route::post('/products/get_product_review', [App\Http\Controllers\ProductController::class, 'get_product_review']);

//cart
Route::get('/cart', [App\Http\Controllers\CartController::class, 'cart_list'])->name('cart');
Route::post('/cart/check_variants', [App\Http\Controllers\CartController::class, 'check_variant'])->name('cart.check_variants');
Route::post('/cart/add_to_cart', [App\Http\Controllers\CartController::class, 'add_to_cart'])->name('cart.add_to_cart');
Route::post('/cart/update_cart', [App\Http\Controllers\CartController::class, 'update_cart'])->name('cart.update_cart');
Route::post('/cart/remove_from_cart', [App\Http\Controllers\CartController::class, 'remove_from_cart'])->name('cart.remove_from_cart');

//common
Route::get('/pdf_invoice/{id}', [App\Http\Controllers\CommonController::class, 'pdf_invoice'])->name('pdf_invoice');
Route::post('/get_search_result', [App\Http\Controllers\CommonController::class, 'get_search_result'])->name('get_search_result');

//whishlist
Route::post('/wishlist/add_remove', [App\Http\Controllers\WishlistController::class, 'add_to_wishlist'])->name('wishlist.add_remove');

//ckeckout
Route::get('/ckeckout', [App\Http\Controllers\ChechOutController::class, 'index'])->name('ckeckout');
Route::post('/ckeckout/render_summary', [App\Http\Controllers\ChechOutController::class, 'render_summary'])->name('ckeckout.render_summary');

//order
Route::post('/order/place_order', [App\Http\Controllers\OrderController::class, 'place_order'])->name('order.place_order');
Route::get('/order/pyamnet/{id}', [App\Http\Controllers\OrderController::class, 'pyamnet'])->name('order.pyamnet');
Route::post('/order/order_payment', [App\Http\Controllers\OrderController::class, 'order_payment'])->name('order.order_payment');
Route::get('/order/order_responce/{id}', [App\Http\Controllers\OrderController::class, 'order_responce'])->name('order.order_responce');
Route::post('/order/cancel_order', [App\Http\Controllers\OrderController::class, 'cancel_order'])->name('order.cancel_order');
Route::post('/order/order_return', [App\Http\Controllers\OrderController::class, 'order_return'])->name('order.order_return');

//address
Route::post('/address/add_update', [App\Http\Controllers\AddressController::class, 'add_and_update_address'])->name('address.add_update');
Route::post('/address/remove_address', [App\Http\Controllers\AddressController::class, 'remove_address'])->name('address.remove_address');


Route::get('/ContactUs', [App\Http\Controllers\ContactUsController::class, 'index'])->name('ContactUs');
Route::post('/ContactUs', [App\Http\Controllers\ContactUsController::class, 'store'])->name('ContactUs');

Route::get('/collections', [App\Http\Controllers\CollectionsController::class, 'index'])->name('collections');
Route::get('/collections/{id}', [App\Http\Controllers\CollectionsController::class, 'collection_details'])->name('collections');


Route::get('/AboutUs',function(){ return view('front.about_us'); })->name('AboutUs');
Route::get('/Privacy',function(){ return view('front.Privacy'); })->name('PrivacyPolicy');
Route::get('/Term',function(){ return view('front.Term'); })->name('TermsAndCondition');
Route::get('/copyright',function(){ return view('front.copyright'); })->name('CopyRight');
Route::get('/refundpolicy',function(){ return view('front.refundpolicy'); })->name('RefundPolicy');
Route::get('/returnpolicy',function(){ return view('front.returnpolicy'); })->name('ReturnPolicy');
Route::get('/shippingpolicy',function(){ return view('front.shippingpolicy'); })->name('ShippingPolicy');
Route::get('/cancellationpolicy',function(){ return view('front.cancellationpolicy'); })->name('CancellationPolicy');



Route::get('/ShippingMethod',function(){ return view('front.support.shipping'); });
Route::get('/PaymentMethod',function(){ return view('front.support.PaymentMethod'); });
Route::get('/OrderTracking',function(){ return view('front.support.OrderTracking'); });
Route::get('/FAQ',function(){ return view('front.support.FAQ'); });


//account
Route::get('/account',function(){ return view('front.account.account'); })->middleware('IsUser');
Route::get('/account/order', [App\Http\Controllers\OrderController::class, 'order_list'])->name('account.order');
Route::get('/account/order/{id}', [App\Http\Controllers\OrderController::class, 'order_details'])->name('account.order.detail');

//wishlist
Route::get('/account/wishlist', [App\Http\Controllers\WishlistController::class, 'wishlist_list'])->name('account.wishlist');

//profile
Route::get('/account/profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('account.profile');
Route::post('/account/update_profile', [App\Http\Controllers\ProfileController::class, 'update_profile'])->name('account.update_profile');
Route::get('/account/change_password', [App\Http\Controllers\ProfileController::class, 'password'])->name('account.change_password');
Route::post('/account/change_password', [App\Http\Controllers\ProfileController::class, 'change_password'])->name('account.change_password');

//address
Route::get('/account/address', [App\Http\Controllers\AddressController::class, 'address_list'])->name('account.address');

//emails
Route::get('/email/order/{id}', [App\Http\Controllers\EmailsController::class, 'order'])->name('email.order');


//sitemap
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);


Route::prefix('seller')->middleware(['auth'])->group(function() {
	
	Route::middleware(['IsAdmin'])->group(function(){
       // Category
		Route::resource('category', App\Http\Controllers\Seller\CategoryController::class);
		
		//Users
		Route::resource('Users', App\Http\Controllers\Seller\UsersController::class);
		
		// Setting	
		Route::controller('App\Http\Controllers\Seller\SettingController')->prefix('setting')->group(function () {
			Route::get('/site_seo', 'site_seo')->name('site_seo');
			Route::post('/update_site_seo/{id}', 'update_site_seo')->name('update_site_seo');
			
			Route::get('/social_links', 'social_links')->name('social_links');
			Route::post('/update_social_links/{id}', 'update_social_links')->name('update_social_links');
		});
		//home banner
		Route::resource('setting/homebanner', App\Http\Controllers\Seller\HomeBannerController::class);
    });

    // Category
    Route::get('/category_name', [App\Http\Controllers\Seller\CategoryController::class, 'category_name'])->name('category_name');
	

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Seller\DashboardController::class, 'index'])->name('seller.dashboard');
    Route::get('/dashboard/get_sales_chart_data', [App\Http\Controllers\Seller\DashboardController::class, 'get_sales_chart_data'])->name('seller.dashboard.get_sales_chart_data');
	
	// coupons
    Route::resource('coupons', App\Http\Controllers\Seller\CouponsController::class);
    Route::post('coupons/updates/{id}', [App\Http\Controllers\Seller\CouponsController::class, 'updates'])->name('coupons.updates');
    Route::post('coupons/add_product', [App\Http\Controllers\Seller\CouponsController::class, 'add_product'])->name('coupons.add_product');
    Route::post('coupons/remove_product', [App\Http\Controllers\Seller\CouponsController::class, 'remove_product'])->name('coupons.remove_product');

    // Product
    Route::resource('product', App\Http\Controllers\Seller\ProductController::class);
	Route::post('product/upload_images/{id}', [App\Http\Controllers\Seller\ProductController::class, 'upload_images'])->name('upload_images');
	Route::post('product/deleteimage', [App\Http\Controllers\Seller\ProductController::class, 'deleteimage'])->name('deleteimage');
	Route::post('/get_product_by_category', [App\Http\Controllers\Seller\ProductController::class, 'get_product_by_category'])->name('get_product_by_category');
	Route::post('/insert_product_variant/{id}', [App\Http\Controllers\Seller\ProductController::class, 'insert_product_variant'])->name('insert_product_variant');
	Route::get('/products_variants/{id}', [App\Http\Controllers\Seller\ProductController::class, 'products_variants'])->name('products_variants');
	Route::post('/change_variant_amount', [App\Http\Controllers\Seller\ProductController::class, 'change_variant_amount'])->name('change_variant_amount');
	Route::post('/delete_product_variant', [App\Http\Controllers\Seller\ProductController::class, 'delete_product_variant'])->name('delete_product_variant');
	Route::post('/delete_all_product_variant', [App\Http\Controllers\Seller\ProductController::class, 'delete_all_product_variant'])->name('delete_all_product_variant');
	Route::post('/change_alert_qty', [App\Http\Controllers\Seller\ProductController::class, 'change_alert_qty'])->name('change_alert_qty');
	Route::post('/change_variant_qty', [App\Http\Controllers\Seller\ProductController::class, 'change_variant_qty'])->name('change_variant_qty');
	Route::post('/change_variant_status', [App\Http\Controllers\Seller\ProductController::class, 'change_variant_status'])->name('change_variant_status');
	Route::get('product/logs/{id}', [App\Http\Controllers\Seller\ProductController::class, 'logs'])->name('product.logs');
	Route::get('product/product_review/{id}', [App\Http\Controllers\Seller\ProductController::class, 'product_review'])->name('product.product_review');
	
	Route::post('product/import', [App\Http\Controllers\Seller\ProductController::class, 'import'])->name('product.import');
	
	// Orders
    Route::resource('Order', App\Http\Controllers\Seller\OrderController::class);
	Route::post('Order/change_order_details', [App\Http\Controllers\Seller\OrderController::class, 'change_order_details'])->name('Order.change_order_details');
	Route::post('Order/change_order_address', [App\Http\Controllers\Seller\OrderController::class, 'change_order_address'])->name('Order.change_order_address');
	Route::post('Order/order_bulk_action', [App\Http\Controllers\Seller\OrderController::class, 'order_bulk_action'])->name('Order.order_bulk_action');
	
	
	// Setting	
	Route::controller('App\Http\Controllers\Seller\ProfileController')->prefix('profile')->group(function () {
		Route::get('/', 'profile')->name('sellerprofile');
		Route::post('/updateprofile/{id}', 'updateprofile')->name('updatesellerprofile');
	});
	
	
	
	// contact us
    Route::resource('faq', App\Http\Controllers\Seller\FaqController::class);
	Route::controller(LagelPagesController::class)->group(function () {
		Route::get('lagel-pages', 'index')->name('lagel-pages');
		Route::get('lagel-pages/{id}', 'edit')->name('lagel-pages.edit');
		Route::post('lagel-pages/{id}', 'update')->name('lagel-pages.update');
	});
    Route::resource('contactus', App\Http\Controllers\Seller\ContactUsController::class);
	//Route::get('/Orders/reports',function(){ dd('a'); });
	

    
});
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'destroy'])
        ->name('logout');


// require __DIR__.'/auth.php';
