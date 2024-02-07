<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::post('/user-login',[UserController::class,'login']);
Route::post('/verify',[UserController::class,'verify'])->name('verify');


//Auth Routes
Route::view('/login','auth.pages.login-page')->name('login');
Route::view('/verify','auth.pages.verify-page')->name('verify');
Route::view('/dashboard','admin.pages.dashboard')->name('register');
Route::view('/brand','admin.pages.brand-page')->name('brand');
Route::view('/category','admin.pages.category-page')->name('category');
Route::view('/product','admin.pages.product-page')->name('product');

//Route Group for Admin

Route::group(['middleware' => ['auth:sanctum','user']], function () {
    Route::get('/', function () {return view('welcome');});
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
});
