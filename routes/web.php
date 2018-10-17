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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user', 'UserController');

Route::resource('product', 'ProductController');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/order/store', [
    'as' => 'order.store', 'uses' => 'OrderController@store'
]);

Route::get('order', ['as' => 'order.index', 'uses' => 'OrderController@index']);

Route::get('basket', ['as' => 'user.basket', 'uses' => 'UserController@basket']);

