<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAuthsController;
use App\Http\Controllers\Admin\DashbordController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CatagoryController;
use App\Http\Controllers\Admin\CuponController;
use App\Http\Controllers\Admin\PacketSizeController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\SingleProductController;
use App\Http\Controllers\User\orderItemController;

Route::get('/login',[UserController::class,'viewLogin'])->name('login');
Route::post('/login',[UserController::class,'loginData'])->name('login');
Route::get('/register',[UserController::class,'viewRegister'])->name('register');
Route::post('/register',[UserController::class,'registerData'])->name('register');
Route::post('/logout', [UserController::class,'logout'])->name('logout');
Route::get('/reset-password', [UserController::class,'index'])->name('reset-password');
Route::post('/reset-password', [UserController::class,'reset'])->name('reset-password');

Route::match(array('GET','POST'),'/otp/{id}',[UserController::class,'otp'])->name('otp');
Route::match(array('GET','POST'),'/new-password/{id}',[UserController::class,'newPassword'])->name('new-password');



Route::get('/', [ProductController::class,'home'])->name('/');

Route::get('/get-address', [AddressController::class,'showAddress'])->name('get-address');
Route::post('/active-address', [AddressController::class,'activeAddress'])->name('active-address');
Route::post('/active-address-new', [AddressController::class,'activeAddressnew'])->name('active-address-new');

Route::get('/address', [AddressController::class,'index'])->name('/address');
Route::post('/address', [AddressController::class,'createAddress'])->name('/address');
Route::get('/edit-address/{id}', [AddressController::class,'updateAddress'])->name('/edit-address');
Route::post('/edit-address/{id}', [AddressController::class,'updateAddressData'])->name('/edit-address');

Route::get('/single_product/{id}', [SingleProductController::class,'index'])->name('/single_product');
// Route::post('/single_product/{id}', [SingleProductController::class,'index'])->name('/single_product');
Route::post('/single_product/{id}', [CartController::class,'index'])->name('/single_product');
Route::get('/cart/{id}',[CartController::class,'cartView'])->middleware('user_auth');
Route::post('/cart/{id}',[CartController::class,'cartOperation'])->middleware('user_auth');
Route::post('/cart-update',[CartController::class,'cartUpadte'])->middleware('user_auth');
Route::post('/cart-checkout/{id}',[CartController::class,'cartDelete'])->middleware('user_auth');
Route::get('/shop', [ShopController::class,'index'])->name('shop');
Route::post('/shop', [ShopController::class,'index'])->name('shop');
Route::get('/shop/{id}', [ShopController::class,'cata'])->name('shop.cata');
Route::post('/shop/{id}', [ShopController::class,'cata'])->name('shop.cata');


Route::get('/about', function () {
    return view('user.pages.about');
})->name('about');

Route::get('/checkout/{id}',[CheckoutController::class,'index'])->middleware('user_auth');
Route::post('/orderitem',[orderItemController::class,'orderItem'])->middleware('user_auth')->name('orderitem');
Route::get('/view-order-item/{id}',[orderItemController::class,'showItem'])->middleware('user_auth');

Route::get('/contract', function () {
    return view('user.pages.contract');
})->name('contract');

// Route::get('/buy-checkout/{id}',[orderItemController::class,'buyIndex'])->middleware('user_auth')->name('buy-checkout');


//admin Api
Route::get('/admin',[AdminAuthsController::class,'viewLogin'])->name('admin');
Route::post('/admin',[AdminAuthsController::class,'loginData'])->name('admin');
Route::group(['middleware'=>'admin_auth'],function () {
    Route::prefix('admin')->group(function(){
        Route::get('/dashboard',[DashbordController::class,'index'])->name('dashboard');
        // Route::get

        //catagory All Api
        Route::get('/catagory',[CatagoryController::class,'index'])->name('catagory');
        Route::get('/create-catagory',[CatagoryController::class,'createView'])->name('create-catagory');
        Route::post('/create-catagory',[CatagoryController::class,'createData'])->name('create-catagory');
        Route::get('/edit-catagory/{id}',[CatagoryController::class,'editView'])->name('edit-catagory');
        Route::post('/edit-catagory/{id}',[CatagoryController::class,'editData'])->name('edit-catagory');
        Route::get('/delete-catagory/{id}',[CatagoryController::class,'destroy'])->name('delete-catagory');

        //cuppon all api
        Route::get('/cupon',[CuponController::class,'index'])->name('cupon');
        Route::get('/create-cupon',[CuponController::class,'createView'])->name('create-cupon');
        Route::post('/create-cupon',[CuponController::class,'createData'])->name('create-cupon');
        Route::get('/edit-cupon/{id}',[CuponController::class,'editView'])->name('edit-cupon');
        Route::post('/edit-cupon/{id}',[CuponController::class,'editData'])->name('edit-cupon');
        Route::get('/delete-cupon/{id}',[CuponController::class,'destroy'])->name('delete-cupon');

        //Packer Size
        Route::get('/packet-size',[PacketSizeController::class,'index'])->name('packet-size');
        Route::get('/create-packet-size',[PacketSizeController::class,'createView'])->name('create-packet-size');
        Route::post('/create-packet-size',[PacketSizeController::class,'createData'])->name('create-packet-size');
        Route::get('/edit-packet-size/{id}',[PacketSizeController::class,'editView'])->name('edit-packet-size');
        Route::post('/edit-packet-size/{id}',[PacketSizeController::class,'editData'])->name('edit-packet-size');
        Route::get('/delete-packet-size/{id}',[PacketSizeController::class,'destroy'])->name('delete-packet-size');




        Route::get('/product',[ProductController::class,'index'])->name('product');
        Route::get('/create-product',[ProductController::class,'viewProduct'])->name('create-product');
        Route::post('/create-product',[ProductController::class,'createProduct'])->name('create-product');
        Route::get('/create-image/{id}',[ProductController::class,'imageShow'])->name('create-image');
        Route::post('/create-image/{id}',[ProductController::class,'imageShow'])->name('create-image');
        Route::get('/edit-image/{id}',[ProductController::class,'editImage'])->name('edit-image');
        Route::post('/edit-image/{id}',[ProductController::class,'editImages'])->name('edit-image');
        Route::get('/create-new-image/{id}',[ProductController::class,'createimage'])->name('create-new-image');
        Route::post('/create-new-image/{id}',[ProductController::class,'imageAdd'])->name('create-new-image');
        Route::get('/edit-product/{id}',[ProductController::class,'editProduct'])->name('edit-product');
        Route::post('/edit-product/{id}',[ProductController::class,'edit'])->name('edit-product');
        Route::get('/delete-product/{id}',[ProductController::class,'destroy'])->name('delete-product');


        //order Item
        Route::get('/order_item',[orderItemController::class,'orderCheck'])->name('order_item');
        Route::get('/edit_item/{id}',[orderItemController::class,'delivered'])->name('edit_item');
        Route::get('/already_deliver',[orderItemController::class,'showDelivered'])->name('already_deliver');
    });

});

