<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCategories;
use DB;

class ProductCategoriesController extends Controller
{
	public function index()
	{
		$title = 'Список продукции';
		$products = ProductCategories::all();

		return view('admin.product_categories', ['title' => $title,'products' => $products ]);

	}


	public function show($id)
	{
		$product = ProductCategories::find($id);
		$title = 'Изменение продукта '.$product->name;

		return view('admin.product_categories_update', ['title' => $title, 'product' => $product ]);
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
        return view('admin.product_categories_add', ['title' => $title]);
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
		DB::table('sellers_to_product_categories')
		->where('product_category_id', '=', $id)
		->delete();

		DB::table('product_categories')
		->where('id', '=', $id)
		->delete();

		return redirect()->route('adminCategories');
	}
}
