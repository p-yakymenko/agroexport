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
}
