<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\ProductCategories;
use App\Categories;
use DB;

class CategoriesController extends AdminController
{
	public function index()
	{
		$category_arr = parent::getCategoryArr();
		$categories = Categories::all()->sortBy("name");
		$title = 'Список категорий';
		$region_arr = parent::getRegionArr('fermeri');
		$products = ProductCategories::all()->sortBy("name");

		return view('admin.categories', ['title' => $title,'products' => $products, 'region_arr' =>  $region_arr, 'categories' => $categories, 'category_arr' => $category_arr ]);

	}


	public function show($id)
	{
		$category_arr = parent::getCategoryArr();
		$category = Categories::find($id);
		$region_arr = parent::getRegionArr('fermeri');
		$title = 'Изменение категории '.$category->name;
		$products = ProductCategories::all()->sortBy("name");

		return view('admin.categories_update', ['title' => $title, 'products' => $products, 'region_arr' =>  $region_arr , 'category' => $category, 'category_arr' => $category_arr]);
	}


	public function update(Request $request, $id)
	{
		$product_to_be_updated = Categories::find($id);
		$product_to_be_updated-> name = $request->input('name');
		$product_to_be_updated->save();
		return redirect()->route('adminCategories');
	}


	public function showAdd()
	{
		$category_arr = parent::getCategoryArr();
		$title = 'Добавление категории';
		$region_arr = parent::getRegionArr('fermeri');
		return view('admin.categories_add', ['title' => $title, 'region_arr' =>  $region_arr, 'category_arr' => $category_arr]);
	}


	public function add(Request $request)
	{
		$new_product = new Categories();
		$new_product-> name = $request->input('name');
		$new_product->save();
		return redirect()->route('adminCategories');
	}


	public function destroy(Request $request)
	{
		$id = $request->input('action');

		DB::table('categories')
		->where('id', '=', $id)
		->delete();

		return redirect()->route('adminCategories');
	}
}
