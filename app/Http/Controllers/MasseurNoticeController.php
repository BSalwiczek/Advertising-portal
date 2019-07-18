<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasseurNoticeController extends Controller
{
	public function __construct()
    {
   	   $this->middleware('auth');
   	   $this->middleware('masseur');
    }
    public function create(){
    	return view('masseurs_ads.create');
    }
}
