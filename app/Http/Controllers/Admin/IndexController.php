<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	
	public function index() {
		
		$title = 'Панель администратора';
		
		return view('admin.index', ['title' => $title]);
		
	}

}
