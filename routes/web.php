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
Route::get('/procurement', 'DashboardController@procurement');
Route::get('/reports', 'ReportsController@index');

Auth::routes();

Route::get('/products/action', 'ProductsController@action')->name('products.action');
Route::get('/products/transact', 'ProductsController@transact')->name('products.transact');
Route::get('/products/{product_id}/del', 'ProductsController@del');
Route::get('/products/import', 'ProductsController@import');
Route::post('/products/uploadFile', 'ProductsController@uploadCSVFile');
Route::get('/products/search', 'ProductsController@search');

Route::get('/transactions/get', 'TransactionsController@get')->name('transactions.get');
Route::get('/transactions/success', 'TransactionsController@success');

Route::get('/loss/create/{product_id}', 'LossController@create');

Route::resource('products', 'ProductsController')->except([
    'show'
]);

Route::resource('transactions', 'TransactionsController')->except([
    'edit', 'update'
]);

Route::resource('loss', 'LossController')->except([
    'show', 'destroy'
]);