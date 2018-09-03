<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\ProductCategories;
use DB;
use App;

class ImportExcelController extends AdminController
{
	
    //параметр object это тип продавца
	public function index($object = null) {
		
		$products = ProductCategories::all();
		$title = 'Импорт из Excel '. parent::translitFunc($object);
		
		return view('admin.import_excel', ['title' => $title, 'products' =>  $products, 'object' =>  $object]);
		
	}


    public function importExcel(Request $request, $object){

    	$sellers = parent::objectsAll($object);
    	$file = $request->file('import_file');
    	if (!empty($file)) {
    		$name_file = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
    	}
    	else{
    		echo "<h1>Ошибка! Файл не выбран!</h1>";
    		die();
    	}

    	$products = ProductCategories::all();
    	$result = false;
    	$seller_name_arr = array();

    	foreach ($sellers as $seller) {
    		$seller_name_arr[] = $seller->name;
    	}
		//проверяем есть ли такой продукт, если нет - то добавляем
    	foreach ($products as $product) {
    		if ($name_file == $product->name) {
    			$result = true;
    			$id = $product->id;
    			break;
    		}
    	}

    	if (!$result){
    		$new_product = new ProductCategories();
    		$new_product->name = $name_file;
    		$new_product->save();
    		$id = DB::getPdo()->lastInsertId();			
    	}

    	$excel = App::make('excel');
    	$uploaded_entries = $excel->load($file)->get();

    	$fields = ['name', 'address', 'country', 'phone', 'email', 'site', 'activity_type', 'contact_person'];
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
        
        /*echo '<pre>'. print_r($uploaded_entries,true).'</pre>';
        die();*/
        
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

    	$message = '';
        //заполняем таблицу sellers и sellers_to_product_categories
    	foreach ($value_arr as $value) {
    		if (!empty($value[$key_array[0]])) {
        	    //проверяем наличие продавца, если есть - то не дублируем
    			if (!in_array($value[$key_array[0]], $seller_name_arr)) {												
    				$new_seller = parent::objectsFunc($object);
    				for ($i=0; $i < count($fields); $i++) {
    					if ($value[$key_array[$i]]) {
    						$new_seller[$fields[$i]] = $value[$key_array[$i]];
    					} 					
    				}
    				if ($new_seller->save()) {
    					$message = 'Файл успешно импортирован!';
    				}
    				$id_seller = DB::getPdo()->lastInsertId();
    			}
    			else{
    				foreach ($sellers as $seller) {
    					if ($value[$key_array[0]] == $seller->name) {
    						$id_seller = $seller->id;
    						break;
    					}
    				}
    			}
                //проверяем наличие связи между продавцом и продуктом, если есть - то не дублируем
    			$objCategories = DB::select('select * from '.parent::tableName($object).'s_to_product_categories');
    			$result_relations = false;
    			
    			if ($object == 'eksportyori') {    			
    				foreach ($objCategories as $relations) {
    					if ($id_seller == $relations->exporter_id && $id == $relations->product_category_id) {
    						$result_relations = true;
    						break;
    					}
    				}
    			}
    			elseif ($object == 'importyori') {    			
    				foreach ($objCategories as $relations) {
    					if ($id_seller == $relations->importer_id && $id == $relations->product_category_id) {
    						$result_relations = true;
    						break;
    					}
    				}
    			}
    			elseif ($object == 'fermeri') {    			
    				foreach ($objCategories as $relations) {
    					if ($id_seller == $relations->farm_id && $id == $relations->product_category_id) {
    						$result_relations = true;
    						break;
    					}
    				}
    			}
    			elseif ($object == 'proizvoditeli') {    			
    				foreach ($objCategories as $relations) {
    					if ($id_seller == $relations->manufacturer_id && $id == $relations->product_category_id) {
    						$result_relations = true;
    						break;
    					}
    				}
    			}
    			
    			if (!$result_relations) {
    				DB::table(parent::tableName($object).'s_to_product_categories')
    				->insert([parent::tableName($object).'_id' => $id_seller, 'product_category_id' => $id]);
    			}

    		}
    	}

    	//$title = 'Импорт из Excel '. parent::translitFunc($object);
    	//return view('admin.import_excel', ['title' => $title, 'products' =>  $products, 'message' =>  $message, 'object' =>  $object]);

        //выясняем id и имя продукта     
        foreach ($products as $value) {
            if ($value->name == $name_file) {
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
            elseif ($object == 'fermeri') {             
                $new_sellers[] = $value->farm_id; 
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

}
