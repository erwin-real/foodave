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

Route::get('/', function () { return view('welcome'); });
Route::get('/dashboard', 'DashboardController@index');
Route::get('/reports', 'ReportsController@index');

Auth::routes();

Route::get('/products/action', 'ProductsController@action')->name('products.action');
Route::get('/products/transact', 'ProductsController@transact')->name('products.transact');
Route::get('/products/{product_id}/del', 'ProductsController@del');

// HELP ROUTES
Route::get('/procurement', 'DashboardController@procurement');

Route::resource('products', 'ProductsController');
Route::resource('transactions', 'TransactionsController');
