<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sellers;
use App\ProductCategories;
use Transliterate;
use DB;

class SellersController extends Controller
{

    public function index($product = null)
    {
        $products = ProductCategories::all();
        
        foreach ($products as $value) {
            if (Transliterate::make($value->name, ['type' => 'url', 'lowercase' => true]) == $product) {
                $our_product = $value->name;
            }
        }
                
        $title = 'Список экспортёров '.$our_product;
        $sellers = Sellers::all();
        $objCategories = DB::select('select * from sellers_to_product_categories');
        //находим продукты(id) связанные с продавцом
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
        //переводим id продуктов в названия
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
        //отфильтровуем продавцов по нужному продукту
        $new_sellers = array();
        foreach ($sellers as $seller) {
            if (in_array($our_product, $seller->arrayCatNames)) {
                $new_sellers[] =  $seller;
            }
        }

        return view('admin.sellers', ['title' => $title,'sellers' => $new_sellers, 'products' =>  $products ]);
    }

    
    public function showAdd()
    {
        $products = ProductCategories::all();
        $title = 'Добавление экспортера';
        return view('admin.sellers_add', ['title' => $title, 'products' => $products ]);
    }


    public function add(Request $request)
    {
        $products = ProductCategories::all();
        $arrayCatNames = $request->input('arrayCatNames');
        $new_seller = new Sellers();
        $fields = ['name', 'address', 'country', 'phone', 'email', 'site', 'activity_type', 'contact_person'];
        
        foreach($fields as $field){
            $new_seller->$field = $request->input($field);
        }

        for ($i=0; $i < count($arrayCatNames); $i++) { 
            foreach ($products as $product) {
                if ($arrayCatNames[$i] == $product->name) {
                    $arrayCategories[] = $product->id;
                }
            }
        }
        
        if ($new_seller->save()) {
            $message = 'Запись успешно сохранена!';
        }
        $id = DB::getPdo()->lastInsertId();

        for ($i=0; $i < count($arrayCategories); $i++) { 
            DB::table('sellers_to_product_categories')
            ->insert(['seller_id' => $id, 'product_category_id' => $arrayCategories[$i]]);
        }

        $title = 'Добавление экспортера';
        return view('admin.sellers_add', ['title' => $title, 'products' => $products, 'message' =>  $message ]);
    }

    
    public function show($id)
    {
        $products = ProductCategories::all();
        $objCategories = DB::select('select * from sellers_to_product_categories');
        $seller = Sellers::find($id);
        $title = 'Изменение экспортера '.$seller->name;
        
        foreach ($objCategories as $category) {
            if ($category->seller_id == $seller->id) {
                $arrayCategories[] = $category->product_category_id;
            }
        }
        $seller->arrayCategories = $arrayCategories;
        
        for ($i=0; $i < count($seller->arrayCategories); $i++) { 
            foreach ($products as $product) {
                if ($seller->arrayCategories[$i] == $product->id) {
                    $arrayCatNames[$i] = $product->name;
                }
            }
        }               
        $seller->arrayCatNames = $arrayCatNames;

        return view('admin.sellers_update', ['title' => $title,'seller' => $seller,'products' => $products ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $products = ProductCategories::all();
        $arrayCatNames = $request->input('arrayCatNames');
        
        $seller_to_be_updated = Sellers::find($id);
        $fields = ['name', 'address', 'country', 'phone', 'email', 'site', 'activity_type', 'contact_person'];

        foreach($fields as $field){
            $seller_to_be_updated->$field = $request->input($field);
        }

        for ($i=0; $i < count($arrayCatNames); $i++) { 
            foreach ($products as $product) {
                if ($arrayCatNames[$i] == $product->name) {
                    $arrayCategories[] = $product->id;
                }
            }
        }
        
        DB::table('sellers_to_product_categories')
        ->where('seller_id', '=', $id)
        ->delete();
        for ($i=0; $i < count($arrayCategories); $i++) { 
            DB::table('sellers_to_product_categories')
            ->insert(['seller_id' => $id, 'product_category_id' => $arrayCategories[$i]]);
        }

        
        if ($seller_to_be_updated->save()) {
            $message = 'Запись успешно сохранена!';
        }

        $seller_to_be_updated->arrayCatNames = $arrayCatNames;
        
        $title = 'Изменение экспортера '.$seller_to_be_updated->name;
        return view('admin.sellers_update', ['title' => $title,'seller' => $seller_to_be_updated,'products' => $products, 'message' =>  $message]);
    }


    public function destroy(Request $request)
    {
        $id = $request->input('action');
        DB::table('sellers_to_product_categories')
        ->where('seller_id', '=', $id)
        ->delete();
        
        DB::table('sellers')
        ->where('id', '=', $id)
        ->delete();

        return redirect()->route('adminIndex');
    }


    public function showSeller($id)
    {
        $products = ProductCategories::all();
        $objCategories = DB::select('select * from sellers_to_product_categories');
        $seller = Sellers::find($id);
        $title = 'Подробная информация об экспортере '.$seller->name;
        
        foreach ($objCategories as $category) {
            if ($category->seller_id == $seller->id) {
                $arrayCategories[] = $category->product_category_id;
            }
        }
        $seller->arrayCategories = $arrayCategories;
        
        for ($i=0; $i < count($seller->arrayCategories); $i++) { 
            foreach ($products as $product) {
                if ($seller->arrayCategories[$i] == $product->id) {
                    $arrayCatNames[$i] = $product->name;
                }
            }
        }               
        $seller->arrayCatNames = $arrayCatNames;

        return view('admin.seller', ['title' => $title,'seller' => $seller,'products' => $products ]);
    }


}
