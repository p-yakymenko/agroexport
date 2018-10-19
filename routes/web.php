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
	
	Route::get('/sellers/{object}/{product?}/{district?}',['uses' => 'Admin\SellersController@index','as' => 'adminSellers']);

	Route::post('/sellers/{object}',['uses' => 'Admin\SellersController@destroy','as' => 'deleteSeller']);

	Route::get('/seller-update/{object}/{id}', 'Admin\SellersController@show');

	Route::get('/seller-add/{object}',['uses'=>'Admin\SellersController@showAdd','as'=>'showAdd']);

	Route::post('/seller-add/{object}',['uses'=>'Admin\SellersController@add','as'=>'sellersAdd']);

	Route::post('/seller-update/{object}/{id}',['uses'=>'Admin\SellersController@update','as'=>'sellersUpdate']);

	Route::get('/seller/{object}/{id}', 'Admin\SellersController@showSeller');

	Route::get('/product-categories',['uses' => 'Admin\ProductCategoriesController@index','as' => 'adminProducts']);

	Route::get('/product-categories/{id}', 'Admin\ProductCategoriesController@show');

	Route::post('/product-categories/{id}',['uses'=>'Admin\ProductCategoriesController@update','as'=>'productUpdate']);

	Route::post('/product-categories',['uses' => 'Admin\ProductCategoriesController@destroy','as' => 'deleteProduct']);

	Route::get('/product-categories-add',['uses'=>'Admin\ProductCategoriesController@showAdd','as'=>'productShow']);

	Route::post('/product-categories-add',['uses'=>'Admin\ProductCategoriesController@add','as'=>'productAdd']);

	Route::get('/import-excel/{object?}', 'Admin\ImportExcelController@index');

	Route::post('/import-excel/{object}', ['uses' => 'Admin\ImportExcelController@importExcel','as'=>'uploadExcel']);	

	Route::get('/users',['uses' => 'Admin\RolesController@index','as' => 'adminUsers']);

	Route::get('/users/{id}', 'Admin\RolesController@show');

	Route::post('/users/{id}',['uses'=>'Admin\RolesController@update','as'=>'userUpdate']);

	Route::post('/users',['uses' => 'Admin\RolesController@destroy','as' => 'deleteUser']);

	Route::get('/user-add',['uses'=>'Admin\RolesController@showAdd','as'=>'showUser']);

	Route::post('/user-add',['uses'=>'Admin\RolesController@add','as'=>'userAdd']);

	Route::get('/categories',['uses' => 'Admin\CategoriesController@index','as' => 'adminCategories']);

	Route::get('/categories/{id}', 'Admin\CategoriesController@show');

	Route::post('/categories/{id}',['uses'=>'Admin\CategoriesController@update','as'=>'categoryUpdate']);

	Route::post('/categories',['uses' => 'Admin\CategoriesController@destroy','as' => 'deleteCategory']);

	Route::get('/categories-add',['uses'=>'Admin\CategoriesController@showAdd','as'=>'categoryShow']);

	Route::post('/categories-add',['uses'=>'Admin\CategoriesController@add','as'=>'categoryAdd']);
});

