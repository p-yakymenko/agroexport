<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\ProductCategories;
use DB;

class ProductCategoriesController extends AdminController
{
	public function index()
	{
		$title = 'Список продукции';
		$region_arr = parent::getRegionArr('fermeri');
		$products = ProductCategories::all();

		return view('admin.product_categories', ['title' => $title,'products' => $products, 'region_arr' =>  $region_arr ]);

	}


	public function show($id)
	{
		$product = ProductCategories::find($id);
		$region_arr = parent::getRegionArr('fermeri');
		$title = 'Изменение продукта '.$product->name;

		return view('admin.product_categories_update', ['title' => $title, 'product' => $product, 'region_arr' =>  $region_arr ]);
	}


	public function update(Request $request, $id)
	{
		$product_to_be_updated = ProductCategories::find($id);
		$fields = ['name', 'description'];

		foreach($fields as $field){
			$product_to_be_updated->$field = $request->input($field);
		}

		$product_to_be_updated->save();
		return redirect()->route('adminCategories');
	}


	    public function showAdd()
    {
        $title = 'Добавление продукта';
        $region_arr = parent::getRegionArr('fermeri');
        return view('admin.product_categories_add', ['title' => $title, 'region_arr' =>  $region_arr]);
    }


    public function add(Request $request)
    {
        $new_product = new ProductCategories();
        $fields = ['name', 'description'];
        
        foreach($fields as $field){
            $new_product->$field = $request->input($field);
        }

        $new_product->save();
        return redirect()->route('adminCategories');
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

		return redirect()->route('adminCategories');
	}
}
