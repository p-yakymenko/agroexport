<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exporters;
use App\Importers;
use App\Farms;
use App\Manufacturers;
use App\Elevators;
use App\Carriers;
use DB;

class AdminController extends Controller
{
	
	protected function translitFunc($word){

		$translit = array(

			'eksportyori' => 'Экспортёры',   
			'importyori' => 'Импортёры',   
			'fermeri' => 'Фермеры',
			'proizvoditeli' => 'Производители',
			'elevatori' => 'Элеваторы',
			'perevozchiki' => 'Перевозчики',

		);

		return $word = strtr($word, $translit);

	}


	protected function objectsFunc($obj){

		$objects = array(

			'eksportyori' => new Exporters(),   
			'importyori' => new Importers(),   
			'fermeri' => new Farms(),
			'proizvoditeli' => new Manufacturers(),
			'elevatori' => new Elevators(),
			'perevozchiki' => new Carriers(),

		);

		return $objects[$obj];

	}


	protected function objectsAll($obj){

		$objects = array(

			'eksportyori' => Exporters::all(),   
			'importyori' => Importers::all(),   
			'fermeri' => Farms::all(),
			'proizvoditeli' => Manufacturers::all(),
			'elevatori' => Elevators::all(),
			'perevozchiki' => Carriers::all(),

		);

		return $objects[$obj];

	}

	
	protected function objectsOne($obj, $id){

		$objects = array(

			'eksportyori' => Exporters::find($id),   
			'importyori' => Importers::find($id),   
			'fermeri' => Farms::find($id),
			'proizvoditeli' => Manufacturers::find($id),
			'elevatori' => Elevators::find($id),
			'perevozchiki' => Carriers::find($id),

		);

		return $objects[$obj];

	}


	protected function tableName($obj){

		$objects = array(

			'eksportyori' => 'exporter',   
			'importyori' => 'importer',   
			'fermeri' => 'farm',
			'proizvoditeli' => 'manufacturer',
			'elevatori' => 'elevator',
			'perevozchiki' => 'carrier',

		);

		return $objects[$obj];

	}


	protected function getRegionArr($object){		

		$new_arr = (object)[];
		$district_name = array();

		$region_arr = DB::table($this->tableName($object).'s')
		->select('region', 'district')
		->orderBy('region')
		->get();

        //создаем массив регионов
		foreach ($region_arr as $region) {
			$new_region = mb_strtoupper(trim($region -> region));
			break;
		}
		$new_district = '';

		foreach ($region_arr as $region) {                
			if ($new_region == mb_strtoupper(trim($region -> region))) {
				if (mb_strtoupper(trim($new_district)) != mb_strtoupper(trim($region -> district))) {
					if (!in_array(mb_strtoupper(trim($region -> district)), $district_name)){
						$district_name[] = mb_strtoupper(trim($region -> district));
						$new_arr->$new_region[] = mb_strtoupper(trim($region -> district));
						$new_district = mb_strtoupper(trim($region -> district));
					}
				}                   
			}
			else{
				$new_region = mb_strtoupper(trim($region -> region));
				if (mb_strtoupper(trim($new_district)) != mb_strtoupper(trim($region -> district))) {
					if (!in_array(mb_strtoupper(trim($region -> district)), $district_name)){
						$district_name[] = mb_strtoupper(trim($region -> district));
						$new_arr->$new_region[] = mb_strtoupper(trim($region -> district));
						$new_district = mb_strtoupper(trim($region -> district));
					}
				}
			}						
		}
/* echo '<pre>'. print_r($new_arr,true).'</pre>';
            die();*/
		//сортируем массив регионов согласно укр. алфавиту
		$sort_arr = (object)[];

		foreach ($new_arr as $k => $value) {
			
			if (!empty($value)) {
				
				usort($value, function ($a, $b){
					$status = 0;
					$a = mb_strtoupper ( $a, 'UTF-8' );
					$b = mb_strtoupper ( $b, 'UTF-8' );
					$alphabet = array(
						'А' => 1, 'Б' => 2, 'В' => 3, 'Г' => 4, 'Д' => 5, 'Е' => 6, 'Є' => 7, 'Ж' => 8, 'З' => 9, 'И' => 10, 'І' => 11,
						'Ї' => 12, 'Й' => 13, 'К' => 14, 'Л' => 15, 'М' => 16, 'Н' => 17, 'О' => 18, 'П' => 19, 'Р' => 20, 'С' => 21, 'Т' => 22,
						'У' => 23, 'Ф' => 24, 'Х' => 25, 'Ц' => 26, 'Ч' => 27, 'Ш' => 28, 'Щ' => 29, 'Ь' => 30, 'Ю' => 31, 'Я' => 32
					);
					$lengthA = mb_strlen ( $a, 'UTF-8' );
					$lengthB = mb_strlen ( $b, 'UTF-8' );
					for( $i = 0; $i < ( $lengthA > $lengthB? $lengthB : $lengthA ); $i++ ){
						if (!empty(mb_substr( $a, $i, 1, 'UTF-8' )) AND !empty(mb_substr( $b, $i, 1, 'UTF-8' ))) {
							
							// КОСТЫЛЬ
							if(mb_substr( $a, $i, 1, 'UTF-8' ) == "'" || mb_substr( $b, $i, 1, 'UTF-8' ) == "'" || mb_substr( $a, $i, 1, 'UTF-8' ) == "." || mb_substr( $b, $i, 1, 'UTF-8' ) == "."){
								return 0;
							}
							// end костыль
							
							if ( $alphabet[ mb_substr( $a, $i, 1, 'UTF-8' ) ] < $alphabet[ mb_substr( $b, $i, 1, 'UTF-8' ) ] ){
								$status = -1;
								break;
							}
							elseif ( $alphabet[ mb_substr( $a, $i, 1, 'UTF-8' ) ] > $alphabet[ mb_substr( $b, $i, 1, 'UTF-8' ) ] ){
								$status = 1;
								break;
							}
							else{
								$status = 0;
							}
						}
					}
					return $status;
				});				

			}
			$sort_arr->$k = $value;
		}

		return $sort_arr;

	}


}
