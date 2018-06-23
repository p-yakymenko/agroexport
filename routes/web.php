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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//admin
Route::group(['prefix' => 'admin','middleware' => 'auth'],function() {
	
	Route::get('/',['uses' => 'Admin\IndexController@index','as' => 'adminIndex']);
	
	Route::get('/sellers',['uses' => 'Admin\SellersController@index','as' => 'adminSellers']);

	Route::post('/sellers',['uses' => 'Admin\SellersController@destroy','as' => 'deleteSeller']);

	Route::get('/sellers/{id}', 'Admin\SellersController@show');

	Route::get('/sellers-add',['uses'=>'Admin\SellersController@showAdd','as'=>'showAdd']);

	Route::post('/sellers-add',['uses'=>'Admin\SellersController@add','as'=>'sellersAdd']);

	Route::post('/sellers/{id}',['uses'=>'Admin\SellersController@update','as'=>'sellersUpdate']);

	Route::get('/product-categories',['uses' => 'Admin\ProductCategoriesController@index','as' => 'adminCategories']);

	Route::get('/product-categories/{id}', 'Admin\ProductCategoriesController@show');

	Route::post('/product-categories/{id}',['uses'=>'Admin\ProductCategoriesController@update','as'=>'productUpdate']);

	Route::post('/product-categories',['uses' => 'Admin\ProductCategoriesController@destroy','as' => 'deleteProduct']);

	Route::get('/product-categories-add',['uses'=>'Admin\ProductCategoriesController@showAdd','as'=>'productShow']);

	Route::post('/product-categories-add',['uses'=>'Admin\ProductCategoriesController@add','as'=>'productAdd']);
});

