<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSliderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::post('/user-login',[UserController::class,'login']);
Route::post('/verify',[UserController::class,'verify'])->name('verify');


//Auth Routes
Route::view('/','auth.pages.home-page')->name('home');
Route::view('/login','auth.pages.login-page')->name('login');
Route::view('/verify','auth.pages.verify-page')->name('verify');
Route::view('/dashboard','admin.pages.dashboard')->name('dashboard');
Route::view('/brand','admin.pages.brand-page')->name('brand');
Route::view('/category','admin.pages.category-page')->name('category');
Route::view('/product','admin.pages.product-page')->name('product');
Route::view('/product-slider','admin.pages.product-slider-page')->name('product-slider');


//Customer Views Routes
Route::view('/user-profile','auth.pages.profile-page')->name('user-profile');
Route::view('/by-category','auth.pages.product-by-category')->name('by-category');
Route::view('/product-by-slider','auth.pages.product-by-brand')->name('by-brand');
Route::view('/product-by-category','auth.pages.product-by-category')->name('by-category');
Route::view('/product-by-brand','auth.pages.product-by-brand')->name('by-category');





Route::get('/Category',[ProductController::class,'productByCategory']);
Route::get('/Brand',[BrandController::class,'productByBrand']);
Route::get('/ProductSlider',[ProductSliderController::class,'productSlider']);
Route::get('/ListProductByRemark/{remark}',[ProductController::class,'productByRemark']);
Route::get('/ListProductByCategory/{id}',[ProductController::class,'ListProductByCategory']);


//Customer Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user-profile',[CustomerProfileController::class,'userProfile']);
    Route::get('/userProfileRead',[CustomerProfileController::class,'userProfileRead']);

});




//Customer Views Routes
Route::view('/user-profile','auth.pages.profile-page')->name('user-profile');

//Customer Routes
 Route::post('/user-profile',[CustomerProfileController::class,'userProfile'])->middleware('auth:sanctum');

//Route Group for Admin

Route::group(['middleware' => ['auth:sanctum','user']], function () {
//Brand Routes
    Route::post('/brand-create',[BrandController::class,'brandCreate']);
    Route::get('/brand-list',[BrandController::class,'brandList']);
    Route::post('/brand-update',[BrandController::class,'brandUpdate']);
    Route::post('/brand-delete',[BrandController::class,'brandDelete']);
    Route::post('/brand-by-id',[BrandController::class,'brandById']);


    //Category Routes
    Route::post('/category-create',[CategoryController::class,'categoryCreate']);
    Route::get('/category-list',[CategoryController::class,'categoryList']);
    Route::post('/category-update',[CategoryController::class,'categoryUpdate']);
    Route::post('/category-delete',[CategoryController::class,'categoryDelete']);
    Route::post('/category-by-id',[CategoryController::class,'categoryById']);


    //Product Routes
    Route::post('/product-create',[ProductController::class,'productCreate']);
    Route::get('/product-list',[ProductController::class,'productList']);
    Route::post('/product-update',[ProductController::class,'productUpdate']);
    Route::post('/product-delete',[ProductController::class,'productDelete']);
    Route::post('/product-by-id',[ProductController::class,'productById']);

    //Product Slider Routes
    Route::post('/product-slider-create',[ProductSliderController::class,'productSliderCreate']);
    Route::get('/product-slider-list',[ProductSliderController::class,'productSliderList']);
    Route::post('/product-slider-update',[ProductSliderController::class,'productSliderUpdate']);
    Route::post('/product-slider-delete',[ProductSliderController::class,'productSliderDelete']);
    Route::post('/product-slider-by-id',[ProductSliderController::class,'productSliderById']);
});
