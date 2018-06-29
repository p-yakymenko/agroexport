<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sellers;
use App\ProductCategories;
use DB;

class IndexController extends Controller
{
	
	/*public function index() {
		
		$title = 'Панель администратора';
		
		return view('admin.index', ['title' => $title]);
		
	}
*/

	    public function index()
    {
        $title = 'Список экспортёров';
        $sellers = Sellers::all();
        $products = ProductCategories::all();
        $objCategories = DB::select('select * from sellers_to_product_categories');
        foreach ($sellers as $seller) {
            if ($seller->id) {
                $arrayCategories = array();
                foreach ($objCategories as $category) {
                    if ($category->seller_id == $seller->id) {
                        $arrayCategories[] = $category->product_category_id;
                    }
                }
            }
            $seller->arrayCategories = $arrayCategories;
        }
        foreach ($sellers as $seller) {
            if ($seller->arrayCategories) {
                $arrayCatNames = array();
                for ($i=0; $i < count($seller->arrayCategories); $i++) { 
                    foreach ($products as $product) {
                        if ($seller->arrayCategories[$i] == $product->id) {
                            $arrayCatNames[$i] = $product->name;
                        }
                    }
                }               
            }
            $seller->arrayCatNames = $arrayCatNames;
        }

        return view('admin.index', ['title' => $title,'sellers' => $sellers ]);
    }
}
