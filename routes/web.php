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

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('user', 'UserController');

Route::resource('product', 'ProductController');
Route::resource('basket', 'BasketController');


Route::get('/home', 'HomeController@index')->name('home');

Route::post('/order/store', [
    'as' => 'order.store', 'uses' => 'OrderController@store'
]);

Route::get('order', ['as' => 'order.index', 'uses' => 'OrderController@index']);

