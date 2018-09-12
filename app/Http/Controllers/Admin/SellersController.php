<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\ProductCategories;
use Transliterate;
use DB;

class SellersController extends AdminController
{

    //параметр object это тип продавца
    public function index($object = null, $product = null)
    {

        $products = ProductCategories::all();

        if ($object != 'fermeri' ) {

            //выясняем id и имя продукта     
            foreach ($products as $value) {
                if (Transliterate::make($value->name, ['type' => 'url', 'lowercase' => true]) == $product) {
                    $our_product = $value->name;
                    $id_product = $value->id;
                }
            }

            //отфильтровуем продавцов по нужному продукту
            $new_sellers = array();
            $our_sellers = DB::table(parent::tableName($object).'s_to_product_categories')
            ->select(parent::tableName($object).'_id')
            ->where('product_category_id', '=', $id_product)
            ->get();

            foreach ($our_sellers as $key => $value) {
                if ($object == 'eksportyori') { 
                    $new_sellers[] = $value->exporter_id;                               
                }
                elseif ($object == 'importyori') {              
                    $new_sellers[] = $value->importer_id; 
                }
                elseif ($object == 'proizvoditeli') {               
                    $new_sellers[] = $value->manufacturer_id; 
                }
                elseif ($object == 'elevatori') {             
                    $new_sellers[] = $value->elevator_id; 
                }
                elseif ($object == 'perevozchiki') {               
                    $new_sellers[] = $value->carrier_id; 
                }            
            }
            
            
            $sellers = DB::table(parent::tableName($object).'s')->whereIn('id', $new_sellers)->paginate(10);        
            
            $title = 'Список '.parent::translitFunc($object).' '.$our_product;
            $objCategories = DB::select('select * from '.parent::tableName($object).'s_to_product_categories');

            //находим продукты(id) связанные с продавцом
            foreach ($sellers as $seller) {
                if ($seller->id) {
                    $arrayCategories = array();

                    if ($object == 'eksportyori') {             
                        foreach ($objCategories as $category) {
                            if ($category->exporter_id == $seller->id) {
                                $arrayCategories[] = $category->product_category_id;
                            }
                        }
                    }
                    elseif ($object == 'importyori') {              
                        foreach ($objCategories as $category) {
                            if ($category->importer_id == $seller->id) {
                                $arrayCategories[] = $category->product_category_id;
                            }
                        }
                    }
                    elseif ($object == 'proizvoditeli') {               
                        foreach ($objCategories as $category) {
                            if ($category->manufacturer_id == $seller->id) {
                                $arrayCategories[] = $category->product_category_id;
                            }
                        }
                    }
                    elseif ($object == 'elevatori') {             
                        foreach ($objCategories as $category) {
                            if ($category->elevator_id == $seller->id) {
                                $arrayCategories[] = $category->product_category_id;
                            }
                        }
                    }
                    elseif ($object == 'perevozchiki') {               
                        foreach ($objCategories as $category) {
                            if ($category->carrier_id == $seller->id) {
                                $arrayCategories[] = $category->product_category_id;
                            }
                        }
                    }

                }
                $seller->arrayCategories = $arrayCategories;
            }
            
            //переводим id продуктов в названия
            $arrayCatNames = array();
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

            
            return view('admin.sellers', ['title' => $title,'sellers' => $sellers, 'products' =>  $products, 'object' =>  $object]); 
        }
        else{

            $sellers = DB::table(parent::tableName($object).'s')->paginate(10);
            $title = 'Список '.parent::translitFunc($object);
            $region_arr = DB::table(parent::tableName($object).'s')
            ->select('region', 'district')
            ->orderBy('region')
            ->get();

            //создаем массив регионов
            foreach ($region_arr as $region) {
                $new_region = $region -> region;
                break;
            }
            $new_district = '';

            foreach ($region_arr as $region) {                
                if ($new_region == $region -> region) {
                    if ($new_district != $region -> district) {
                        $new_arr->$new_region[] = $region -> district;
                        $new_district = $region -> district;
                    }                   
                }
                else{
                    $new_region = $region -> region;
                    if ($new_district != $region -> district) {
                        $new_arr->$new_region[] = $region -> district;
                        $new_district = $region -> district;
                    }
                }
            }

            /*echo '<pre>'. print_r($new_arr,true).'</pre>';
            die();*/
            return view('admin.farmers', ['title' => $title,'sellers' => $sellers, 'products' =>  $products, 'object' =>  $object, 'region_arr' =>  $new_arr]);
        }

    }

    
    public function showAdd($object)
    {
        $products = ProductCategories::all();
        $title = 'Добавление '. parent::translitFunc($object);
        return view('admin.sellers_add', ['title' => $title, 'products' => $products, 'object' =>  $object ]);
    }


    public function add(Request $request, $object)
    {
        $products = ProductCategories::all();
        $arrayCatNames = $request->input('arrayCatNames');
        $new_seller = parent::objectsFunc($object);
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
            DB::table(parent::tableName($object).'s_to_product_categories')
            ->insert([parent::tableName($object).'_id' => $id, 'product_category_id' => $arrayCategories[$i]]);
        }

        $title = 'Добавление '. parent::translitFunc($object);
        return view('admin.sellers_add', ['title' => $title, 'products' => $products, 'message' =>  $message, 'object' =>  $object ]);
    }

    
    public function show($object, $id)
    {
        $products = ProductCategories::all();
        $objCategories = DB::select('select * from '.parent::tableName($object).'s_to_product_categories');
        $seller = parent::objectsOne($object, $id);
        $title = 'Изменение '. parent::translitFunc($object).' '.$seller->name;
        
        if ($object == 'eksportyori') {             
            foreach ($objCategories as $category) {
                if ($category->exporter_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'importyori') {              
            foreach ($objCategories as $category) {
                if ($category->importer_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'fermeri') {             
            foreach ($objCategories as $category) {
                if ($category->farm_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'proizvoditeli') {               
            foreach ($objCategories as $category) {
                if ($category->manufacturer_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'elevatori') {             
            foreach ($objCategories as $category) {
                if ($category->elevator_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'perevozchiki') {               
            foreach ($objCategories as $category) {
                if ($category->carrier_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
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

        return view('admin.sellers_update', ['title' => $title,'seller' => $seller,'products' => $products, 'object' =>  $object ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $object, $id)
    {
        $products = ProductCategories::all();
        $arrayCatNames = $request->input('arrayCatNames');
        
        $seller_to_be_updated = parent::objectsOne($object, $id);
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
        
        DB::table(parent::tableName($object).'s_to_product_categories')
        ->where(parent::tableName($object).'_id', '=', $id)
        ->delete();
        for ($i=0; $i < count($arrayCategories); $i++) { 
            DB::table(parent::tableName($object).'s_to_product_categories')
            ->insert([parent::tableName($object).'_id' => $id, 'product_category_id' => $arrayCategories[$i]]);
        }

        
        if ($seller_to_be_updated->save()) {
            $message = 'Запись успешно сохранена!';
        }

        $seller_to_be_updated->arrayCatNames = $arrayCatNames;
        
        $title = 'Изменение '.parent::translitFunc($object).' '.$seller_to_be_updated->name;
        return view('admin.sellers_update', ['title' => $title,'seller' => $seller_to_be_updated,'products' => $products, 'message' =>  $message, 'object' =>  $object]);
    }


    public function destroy(Request $request, $object)
    {
        $id = $request->input('action');
        DB::table(parent::tableName($object).'s_to_product_categories')
        ->where(parent::tableName($object).'_id', '=', $id)
        ->delete();
        
        DB::table(parent::tableName($object).'s')
        ->where('id', '=', $id)
        ->delete();

        return redirect()->back()->with('message','Запись успешно удалена!');
    }


    public function showSeller($object, $id)
    {
        $products = ProductCategories::all();
        $objCategories = DB::select('select * from '.parent::tableName($object).'s_to_product_categories');
        $seller = parent::objectsOne($object, $id);
        $title = 'Подробная информация об '.parent::translitFunc($object).' '.$seller->name;
        $arrayCategories = array();
        $arrayCatNames = array();

        if ($object == 'eksportyori') {             
            foreach ($objCategories as $category) {
                if ($category->exporter_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'importyori') {              
            foreach ($objCategories as $category) {
                if ($category->importer_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'fermeri') {             
            foreach ($objCategories as $category) {
                if ($category->farm_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'proizvoditeli') {               
            foreach ($objCategories as $category) {
                if ($category->manufacturer_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'elevatori') {             
            foreach ($objCategories as $category) {
                if ($category->elevator_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
            }
        }
        elseif ($object == 'perevozchiki') {               
            foreach ($objCategories as $category) {
                if ($category->carrier_id == $seller->id) {
                    $arrayCategories[] = $category->product_category_id;
                }
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

        return view('admin.seller', ['title' => $title,'seller' => $seller,'products' => $products, 'object' =>  $object ]);
    }


}
