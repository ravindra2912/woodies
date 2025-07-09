<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Category Name
Route::get('/get-home', [App\Http\Controllers\Api\HomeController::class, 'home'])->name('category_name');

// Register & login
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/ForgotPassword', [App\Http\Controllers\Api\AuthController::class, 'ForgotPassword']);
Route::post('/ResetPassword', [App\Http\Controllers\Api\AuthController::class, 'ResetPassword']);

route::get('/faqs', [App\Http\Controllers\Api\HomeController::class, 'faqs'])->name('faqs');
route::post('/contact-us', [App\Http\Controllers\Api\HomeController::class, 'contactUs'])->name('contactus');
// categoreis
Route::post('/categories', [App\Http\Controllers\Api\CategoriesController::class, 'categories'])->name('categories');
	
// products
Route::post('/producs', [App\Http\Controllers\Api\ProducsController::class, 'producs'])->name('producs');
Route::post('/product_details', [App\Http\Controllers\Api\ProducsController::class, 'product_details'])->name('product_details');

Route::group(['middleware' => ['auth:api'], 'prefix' => '/'], function () {
    // Cart
	Route::get('/cart_list', [App\Http\Controllers\Api\AddToCartController::class, 'cart_list'])->name('cart_list');
    Route::post('/add_to_cart', [App\Http\Controllers\Api\AddToCartController::class, 'add_to_cart'])->name('add_to_cart');
    Route::post('/update_cart', [App\Http\Controllers\Api\AddToCartController::class, 'update_cart'])->name('update_cart');
	Route::post('/remove_from_cart', [App\Http\Controllers\Api\AddToCartController::class, 'remove_from_cart'])->name('remove_from_cart');
	Route::post('/cart_count', [App\Http\Controllers\Api\AddToCartController::class, 'cart_count'])->name('cart_count');
	Route::post('/check_variant', [App\Http\Controllers\Api\AddToCartController::class, 'check_variant'])->name('check_variant');

	// wishlist
    Route::post('/add_to_wishlist', [App\Http\Controllers\Api\WishlistController::class, 'add_to_wishlist'])->name('add_to_wishlist');
    Route::post('/wishlist_list', [App\Http\Controllers\Api\WishlistController::class, 'wishlist_list'])->name('wishlist_list');
	
	// Address
    Route::post('/add_and_update_address', [App\Http\Controllers\Api\AddressController::class, 'add_and_update_address'])->name('add_and_update_address');
    Route::post('/address_list', [App\Http\Controllers\Api\AddressController::class, 'address_list'])->name('address_list');
    Route::post('/remove_address', [App\Http\Controllers\Api\AddressController::class, 'remove_address'])->name('remove_address');
	
    // Profile
    Route::get('/profile', [App\Http\Controllers\Api\HomeController::class, 'profile'])->name('profile');
    Route::post('/update_profile', [App\Http\Controllers\Api\HomeController::class, 'update_profile'])->name('update_profile');
    Route::post('/update_profile_image', [App\Http\Controllers\Api\HomeController::class, 'update_profile_image'])->name('update_profile_image');
    Route::post('profile/change-password', [App\Http\Controllers\Api\HomeController::class, 'changePassword'])->name('profile.changePassword');
	
	// order
    Route::post('/coupon_list', [App\Http\Controllers\Api\OrderController::class, 'coupon_list'])->name('coupon_list');
    Route::post('/apply_coupon', [App\Http\Controllers\Api\OrderController::class, 'apply_coupon'])->name('apply_coupon');
    Route::post('/place_order', [App\Http\Controllers\Api\OrderController::class, 'place_order'])->name('place_order');
    Route::post('/order_list', [App\Http\Controllers\Api\OrderController::class, 'order_list'])->name('order_list');
    Route::post('/order_details', [App\Http\Controllers\Api\OrderController::class, 'order_details'])->name('order_details');
    Route::post('/order_payment', [App\Http\Controllers\Api\OrderController::class, 'order_payment'])->name('order_payment');
    Route::post('/replace_product', [App\Http\Controllers\Api\OrderController::class, 'replace_product'])->name('replace_product');
    Route::post('/order_return', [App\Http\Controllers\Api\OrderController::class, 'order_return'])->name('order_return');
    Route::post('/order_cancel', [App\Http\Controllers\Api\OrderController::class, 'order_cancel'])->name('order_cancel');

    // Logout
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');
});
