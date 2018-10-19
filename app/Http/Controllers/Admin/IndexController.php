<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\ProductCategories;
use Transliterate;
use DB;

class IndexController extends AdminController
{

/*    public function index()
    {
        $title = 'Весь список';
        $objects = array();
        $products = ProductCategories::all()->sortBy("name");
        $sellers = Exporters::all();
        $objCategories = DB::select('select * from exporters_to_product_categories');
        foreach ($sellers as $seller) {
            if ($seller->id) {
                $arrayCategories = array();
                foreach ($objCategories as $category) {
                    if ($category->exporter_id == $seller->id) {
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

        $exporters = $sellers;
        $objects[] = 'eksportyori';

        $sellers = Importers::all();
        $objCategories = DB::select('select * from importers_to_product_categories');
        foreach ($sellers as $seller) {
            if ($seller->id) {
                $arrayCategories = array();
                foreach ($objCategories as $category) {
                    if ($category->importer_id == $seller->id) {
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

        $importers = $sellers;
        $objects[] = 'importyori';

        $sellers = Farms::all();
        $objCategories = DB::select('select * from farms_to_product_categories');
        foreach ($sellers as $seller) {
            if ($seller->id) {
                $arrayCategories = array();
                foreach ($objCategories as $category) {
                    if ($category->farm_id == $seller->id) {
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

        $farms = $sellers;
        $objects[] = 'fermeri';

        $sellers = Manufacturers::all();
        $objCategories = DB::select('select * from manufacturers_to_product_categories');
        foreach ($sellers as $seller) {
            if ($seller->id) {
                $arrayCategories = array();
                foreach ($objCategories as $category) {
                    if ($category->manufacturer_id == $seller->id) {
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

        $manufacturers = $sellers;
        $objects[] = 'proizvoditeli';

        return view('admin.index', ['title' => $title,'exporters' => $exporters,'importers' => $importers,'farms' => $farms,'manufacturers' => $manufacturers, 'products' =>  $products, 'objects' =>  $objects]);
    }*/

    public function index(){
        $category_arr = parent::getCategoryArr();
        $products = ProductCategories::all()->sortBy("name");
        $region_arr = parent::getRegionArr('fermeri');
        $title = 'Пользователи';
        $users = DB::select('select * from users');
        return view('admin.users', ['title' => $title,'users' => $users, 'products' =>  $products, 'region_arr' =>  $region_arr, 'category_arr' => $category_arr]);
    }
}
