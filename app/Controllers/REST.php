<?php

namespace App\Controllers;

class REST extends BaseController
{
	public function index()
	{
		return view('rest');
	}
	public function get_todos(){
		return view('hello');
	}
}
