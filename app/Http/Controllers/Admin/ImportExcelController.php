<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sellers;
use App\ProductCategories;
use DB;
use App;

class ImportExcelController extends Controller
{
	
	public function index() {
		
		$products = ProductCategories::all();
		$title = 'Импорт из Excel';
		
		return view('admin.import_excel', ['title' => $title, 'products' =>  $products]);
		
	}


	public function admin_import_post(Request $request){

		/*DB::table('sellers_to_product_categories')
        ->where('product_category_id', '>',9)
        ->delete();
        
        DB::table('sellers')
        ->where('id', '>', 95)
        ->delete();

        die();*/
		
		$sellers = Sellers::all();
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
        
        /*print_r($uploaded_entries);
		die();*/
		
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
					$new_seller = new Sellers();
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
				$objCategories = DB::select('select * from sellers_to_product_categories');
				$result_relations = false;
				foreach ($objCategories as $relations) {
					if ($id_seller == $relations->seller_id && $id == $relations->product_category_id) {
						$result_relations = true;
						break;
					}
				}
				if (!$result_relations) {
					DB::table('sellers_to_product_categories')
					->insert(['seller_id' => $id_seller, 'product_category_id' => $id]);
				}

			}
		}

		$products = ProductCategories::all();
		$title = 'Импорт из Excel';

		return view('admin.import_excel', ['title' => $title, 'products' =>  $products, 'message' =>  $message]);
	}

}
