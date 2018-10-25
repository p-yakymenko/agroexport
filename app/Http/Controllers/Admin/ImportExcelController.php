<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\ProductCategories;
use Transliterate;
use DB;
use App;

class ImportExcelController extends AdminController
{
	
    //параметр object это тип продавца
	public function index($object = null) 
    {

      $category_arr = parent::getCategoryArr();
      $products = ProductCategories::all()->sortBy("name");
      $region_arr = parent::getRegionArr('fermeri');
      $title = 'Импорт из Excel '. parent::translitFunc($object);

      return view('admin.import_excel', ['title' => $title, 'products' =>  $products, 'object' =>  $object, 'region_arr' =>  $region_arr, 'category_arr' => $category_arr]);

  }



  public function importExcel(Request $request, $object) {

    $sellers = parent::objectsAll($object);
    $file = $request -> file('import_file');
    if (!empty($file)) {
        $name_file = $request->input('product_name');
    } else {
        echo "<h1>Ошибка! Файл не выбран!</h1>";
        die();
    }

    $products = ProductCategories::all()->sortBy("name");
    $result = false;
    $seller_name_arr = array();

    foreach($sellers as $seller) {
        $seller_name_arr[] = mb_strtoupper(trim($seller -> name));
    }

    $excel = App::make('excel');
    $uploaded_entries = $excel -> load($file) -> get();


        //---------------обычная загрузка начало-------------//


    if ($name_file != 'Фермеры') {


            //проверяем есть ли такой продукт, если нет - то добавляем
        foreach($products as $product) {
            if ($name_file == $product -> name) {
                $result = true;
                $id = $product -> id;
                break;
            }
        }

        if (!$result) {
            $new_product = new ProductCategories();
            $new_product -> name = $name_file;
            $new_product -> save();
            $id = DB::getPdo() -> lastInsertId();
        }

        $fields = ['name', 'address', 'country', 'phone', 'email', 'site', 'activity_type', 'contact_person'];
            //получаем список полей файла, чтобы не зависело от названия, а только от последовательности и наличия
        foreach($uploaded_entries as $uploaded_entry) {
            foreach($uploaded_entry as $key => $value) {
                if (is_object($value)) {
                    foreach($value as $k => $val) {
                        $key_array[] = $k;
                    }
                    break;
                } else {
                    $key_array[] = $key;
                }
            }
            break;
        }

            //закладываемся на 1 уровень объекта
        foreach($uploaded_entries as $uploaded_entry) {
            foreach($uploaded_entry as $key => $value) {
                if (is_object($value)) {
                    $value_arr[] = $value;
                } else {
                    $value_arr = $uploaded_entries;
                }
            }
        }

        $message = '';
            //заполняем таблицу sellers и sellers_to_product_categories
        foreach($value_arr as $value) {
            if (!empty($value[$key_array[0]])) {
                    //проверяем наличие продавца, если есть - то не дублируем
                if (!in_array(mb_strtoupper(trim($value[$key_array[0]])), $seller_name_arr)) {
                    $seller_name_arr[] = mb_strtoupper(trim($value[$key_array[0]]));
                    $new_seller = parent::objectsFunc($object);
                    for ($i = 0; $i < count($fields); $i++) {
                        if ($value[$key_array[$i]]) {
                            $new_seller[$fields[$i]] = $value[$key_array[$i]];
                        }
                    }
                    if ($new_seller -> save()) {
                        $message = 'Файл успешно импортирован!';
                    }
                    $id_seller = DB::getPdo() -> lastInsertId();
                } else {
                    foreach($sellers as $seller) {
                        if ($value[$key_array[0]] == $seller -> name) {
                            $id_seller = $seller -> id;
                            break;
                        }
                    }
                }
                    //проверяем наличие связи между продавцом и продуктом, если есть - то не дублируем
                $objCategories = DB::select('select * from '.parent::tableName($object).
                    's_to_product_categories');
                $result_relations = false;

                if ($object == 'eksportyori') {
                    foreach($objCategories as $relations) {
                        if ($id_seller == $relations -> exporter_id && $id == $relations -> product_category_id) {
                            $result_relations = true;
                            break;
                        }
                    }
                }
                elseif($object == 'importyori') {
                    foreach($objCategories as $relations) {
                        if ($id_seller == $relations -> importer_id && $id == $relations -> product_category_id) {
                            $result_relations = true;
                            break;
                        }
                    }
                }
                elseif($object == 'fermeri') {
                    foreach($objCategories as $relations) {
                        if ($id_seller == $relations -> farm_id && $id == $relations -> product_category_id) {
                            $result_relations = true;
                            break;
                        }
                    }
                }
                elseif($object == 'proizvoditeli') {
                    foreach($objCategories as $relations) {
                        if ($id_seller == $relations -> manufacturer_id && $id == $relations -> product_category_id) {
                            $result_relations = true;
                            break;
                        }
                    }
                }

                if (!$result_relations) {
                    DB::table(parent::tableName($object).
                        's_to_product_categories') -> insert([parent::tableName($object).
                            '_id' => $id_seller, 'product_category_id' => $id
                        ]);
                    }

                }
            }

            //выясняем id и имя продукта 
            $products = ProductCategories::all()->sortBy("name");
            foreach($products as $value) {
                if ($value -> name == $name_file) {
                    $our_product = $value -> name;
                    $id_product = $value -> id;
                }
            }

            //отфильтровуем продавцов по нужному продукту
            $new_sellers = array();
            $our_sellers = DB::table(parent::tableName($object).
                's_to_product_categories') -> select(parent::tableName($object).
                '_id') -> where('product_category_id', '=', $id_product) -> get();

                foreach($our_sellers as $key => $value) {
                    if ($object == 'eksportyori') {
                        $new_sellers[] = $value -> exporter_id;
                    }
                    elseif($object == 'importyori') {
                        $new_sellers[] = $value -> importer_id;
                    }
                    elseif($object == 'fermeri') {
                        $new_sellers[] = $value -> farm_id;
                    }
                    elseif($object == 'proizvoditeli') {
                        $new_sellers[] = $value -> manufacturer_id;
                    }
                    elseif($object == 'elevatori') {
                        $new_sellers[] = $value -> elevator_id;
                    }
                    elseif($object == 'perevozchiki') {
                        $new_sellers[] = $value -> carrier_id;
                    }
                }

                $sellers = DB::table(parent::tableName($object).
                    's') -> whereIn('id', $new_sellers) -> paginate(10);

                $title = 'Список '.parent::translitFunc($object).
                ' '.$our_product;
                $objCategories = DB::select('select * from '.parent::tableName($object).
                    's_to_product_categories');

                //находим продукты(id) связанные с продавцом
                foreach($sellers as $seller) {
                    if ($seller -> id) {
                        $arrayCategories = array();

                        if ($object == 'eksportyori') {
                            foreach($objCategories as $category) {
                                if ($category -> exporter_id == $seller -> id) {
                                    $arrayCategories[] = $category -> product_category_id;
                                }
                            }
                        }
                        elseif($object == 'importyori') {
                            foreach($objCategories as $category) {
                                if ($category -> importer_id == $seller -> id) {
                                    $arrayCategories[] = $category -> product_category_id;
                                }
                            }
                        }
                        elseif($object == 'fermeri') {
                            foreach($objCategories as $category) {
                                if ($category -> farm_id == $seller -> id) {
                                    $arrayCategories[] = $category -> product_category_id;
                                }
                            }
                        }
                        elseif($object == 'proizvoditeli') {
                            foreach($objCategories as $category) {
                                if ($category -> manufacturer_id == $seller -> id) {
                                    $arrayCategories[] = $category -> product_category_id;
                                }
                            }
                        }
                        elseif($object == 'elevatori') {
                            foreach($objCategories as $category) {
                                if ($category -> elevator_id == $seller -> id) {
                                    $arrayCategories[] = $category -> product_category_id;
                                }
                            }
                        }
                        elseif($object == 'perevozchiki') {
                            foreach($objCategories as $category) {
                                if ($category -> carrier_id == $seller -> id) {
                                    $arrayCategories[] = $category -> product_category_id;
                                }
                            }
                        }

                    }
                    $seller -> arrayCategories = $arrayCategories;
                }

                //переводим id продуктов в названия
                $arrayCatNames = array();
                foreach($sellers as $seller) {
                    if ($seller -> arrayCategories) {
                        $arrayCatNames = array();
                        for ($i = 0; $i < count($seller -> arrayCategories); $i++) {
                            foreach($products as $product) {
                                if ($seller -> arrayCategories[$i] == $product -> id) {
                                    $arrayCatNames[$i] = $product -> name;
                                }
                            }
                        }
                    }
                    $seller -> arrayCatNames = $arrayCatNames;
                }

                $product = Transliterate::make($name_file, ['type' => 'url', 'lowercase' => true]);
                return redirect()->route('adminSellers', ['object' => $object, 'product' => $product]);    

            }


            //---------------обычная загрузка конец-------------//


            else{

                $seller_edrpou_arr = array();

                foreach($sellers as $seller) {
                    $seller_edrpou_arr[] = trim($seller -> edrpou);
                }

            //получаем список полей файла, чтобы не зависело от названия, а только от последовательности и наличия
                foreach ($uploaded_entries as $uploaded_entry) {
                    foreach ($uploaded_entry as $key => $value) {
                        if (is_object($value)) {
                            foreach ($value as $k => $val) {
                                $key_array[]=$k;
                            }
                            break;
                        }
                        else{
                            $key_array[]=$key;
                        }
                    }
                    break;          
                }

                        //закладываемся на 1 уровень объекта
                foreach ($uploaded_entries as $uploaded_entry) {
                  foreach ($uploaded_entry as $key => $value) {             
                     if (is_object($value)) {
                        $value_arr[] = $value;
                    }
                    else{
                        $value_arr = $uploaded_entries;
                    }
                }       
            }    

            $farm_product = ['кукуруза зерно','кукуруза кормовая','ячмень озимый','ячмень яровой','гречка','просо','лён','соя','рапс','горох','фасоль','горчица','подсолнечник','овес','пшеница озимая','пшеница яровая'];

            foreach ($value_arr as $uploaded_entry){

                //проверяем наличие продавца, если есть - то не дублируем
                if (!in_array(trim($uploaded_entry[$key_array[2]]), $seller_edrpou_arr)) {
                    $new_seller = parent::objectsFunc($object);

                    $seller_edrpou_arr[] = trim($uploaded_entry[$key_array[2]]);

                    $new_seller['name'] = $uploaded_entry[$key_array[3]];
                    $new_seller['address'] = $uploaded_entry[$key_array[9]];
                    $new_seller['phone'] = $uploaded_entry[$key_array[4]].' '.$uploaded_entry[$key_array[5]];
                    $new_seller['country'] = 'UA'; 
                    $new_seller['email'] = $uploaded_entry[$key_array[7]];
                    $new_seller['contact_person'] = $uploaded_entry[$key_array[6]]; 
                    $new_seller['region'] = $uploaded_entry[$key_array[0]];
                    $new_seller['edrpou'] = $uploaded_entry[$key_array[2]];
                    if (!empty($uploaded_entry[$key_array[1]])) {
                        $new_seller['district'] = $uploaded_entry[$key_array[1]];
                    }
                    else{
                        $new_seller['district'] = $uploaded_entry[$key_array[0]];
                    }

                    $json = array();

                    for ($i=0; $i < count($farm_product); $i++) { 
                        if (!empty($uploaded_entry[$key_array[$i+10]])) {
                            $json[] = $farm_product[$i];
                        }
                    }

                    $json = json_encode($json,JSON_UNESCAPED_UNICODE);

                    $new_seller['products'] = $json;

                    $new_seller->save(); 
                }
            }

            /*        echo '<pre>'. print_r($key_array,true).'</pre>';
            die();*/

            return redirect()->route('adminSellers', ['object' => $object]);
        }        

    }

}
