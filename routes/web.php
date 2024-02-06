<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::post('/user-login',[UserController::class,'login']);
Route::post('/verify',[UserController::class,'verify'])->name('verify');


//Auth Routes
Route::view('/login','auth.pages.login-page')->name('login');
Route::view('/verify','auth.pages.verify-page')->name('verify');
Route::view('/dashboard','admin.pages.dashboard')->name('register');
Route::view('/brand','admin.pages.brand-page')->name('brand');

//Route Group for Admin

Route::group(['middleware' => ['auth:sanctum','user']], function () {
    Route::get('/', function () {return view('welcome');});
//Brand Routes
    Route::post('/brand-create',[BrandController::class,'brandCreate']);
    Route::get('/brand-list',[BrandController::class,'brandList']);
    Route::post('/brand-update',[BrandController::class,'brandUpdate']);
    Route::post('/brand-delete',[BrandController::class,'brandDelete']);
    Route::post('/brand-by-id',[BrandController::class,'brandById']);
});
