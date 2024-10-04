<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', "WebPageController@index");
Route::get('/orden/{code_orden}', "WebPageController@orden");
Route::post('/post', "WebPageController@crear_orden");

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
