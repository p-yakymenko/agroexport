<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\ProductCategories;
use App\Categories;
use DB;

class ProductCategoriesController extends AdminController
{
	public function index()
	{
		$category_arr = parent::getCategoryArr();
		$title = 'Список продукции';
		$region_arr = parent::getRegionArr('fermeri');
		$products = ProductCategories::all()->sortBy("name");
		$categories = Categories::all()->sortBy("name");
		foreach ($products as $product) {
			foreach ($categories as $category) {
				if ($product -> category_id == $category -> id) {
					$product -> category_name = $category -> name;
				}
			}
		}

		return view('admin.product_categories', ['title' => $title,'products' => $products, 'region_arr' =>  $region_arr, 'category_arr' => $category_arr ]);

	}


	public function show($id)	
	{
		$category_arr = parent::getCategoryArr();
		$product = ProductCategories::find($id);
		$categories = Categories::all()->sortBy("name");
		$new_categories = array( );
		$region_arr = parent::getRegionArr('fermeri');
		$title = 'Изменение продукта '.$product->name;
		$selected = '';

		foreach ($categories as $value) {
			if ($product -> category_id == $value -> id) {
				$selected = $value -> id;
			}
			$new_categories[$value -> id] = $value -> name;
		}

		return view('admin.product_categories_update', ['title' => $title, 'product' => $product, 'region_arr' =>  $region_arr, 'categories' => $new_categories, 'selected' => $selected, 'category_arr' => $category_arr]);
	}


	public function update(Request $request, $id)
	{
		$product_to_be_updated = ProductCategories::find($id);
		$fields = ['name', 'description', 'category_id'];

		foreach($fields as $field){
			$product_to_be_updated->$field = $request->input($field);
		}

		$product_to_be_updated->save();
		return redirect()->route('adminProducts');
	}


	public function showAdd()
    {
    	$category_arr = parent::getCategoryArr();
        $title = 'Добавление продукта';
        $categories = Categories::all()->sortBy("name");
        $new_categories = array( );
        $region_arr = parent::getRegionArr('fermeri');
        foreach ($categories as $value) {
			$new_categories[$value -> id] = $value -> name;
		}
        return view('admin.product_categories_add', ['title' => $title, 'region_arr' =>  $region_arr, 'categories' => $new_categories, 'category_arr' => $category_arr]);
    }


    public function add(Request $request)
    {
        $new_product = new ProductCategories();
        $fields = ['name', 'description', 'category_id'];
        
        foreach($fields as $field){
            $new_product->$field = $request->input($field);
        }

        $new_product->save();
        return redirect()->route('adminProducts');
    }


	public function destroy(Request $request)
	{
		$id = $request->input('action');
		DB::table('exporters_to_product_categories')
		->where('product_category_id', '=', $id)
		->delete();

		DB::table('importers_to_product_categories')
		->where('product_category_id', '=', $id)
		->delete();

		DB::table('manufacturers_to_product_categories')
		->where('product_category_id', '=', $id)
		->delete();

		DB::table('elevators_to_product_categories')
		->where('product_category_id', '=', $id)
		->delete();

		DB::table('carriers_to_product_categories')
		->where('product_category_id', '=', $id)
		->delete();

		DB::table('product_categories')
		->where('id', '=', $id)
		->delete();

		return redirect()->route('adminProducts');
	}
}
