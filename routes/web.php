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


Route::get('prueba', function (){
    return view("prueba");
})->name("prueba");
Route::get('/orden/{code_orden}', "WebPageController@orden");
Route::post('/post', "WebPageController@crear_orden");
Route::get('pruebas', "WebPageController@prueba");

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('domicilios', "WebPageController@domicilios_vista");
    Route::get('domicilios', "WebPageController@domicilios_vista");
    Route::get('aceptacion/{id}', "WebPageController@aceptar");
    Route::get('cliente_informacion/{id}', "WebPageController@cliente_informacion");
    Route::get('status/{id}', "WebPageController@status")->name("status");
    Route::get('verentrega/{id}', "WebPageController@status")->name("verentrega");
    Route::get('confirmar/{id}', "WebPageController@confirmar")->name("confirmar");
    Route::get('/sse/domicilios', "WebPageController@stream");

    Route::get('facturar/{id}', "WebPageController@facturar")->name("facturar");
});
