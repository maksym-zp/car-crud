<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'CarController@index')->name('home');
    Route::resource('car', 'CarController');
    Route::resource('brand', 'BrandController');
    Route::post('/upload-image', 'CarController@saveImage')->name('saveImage');
});

