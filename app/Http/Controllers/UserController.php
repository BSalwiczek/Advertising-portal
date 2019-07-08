<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request){
    	$this->validate($request, [
    		'name'=>'required|string|max:30',
    		'surname'=>'required|string|max:30',
    		'email'=>'required|email|max:50',
    		'password'=>'required|min:8|max:30',
    		'accept_terms'=>'accepted',

    	]);

    	// return response()->json(null,200);
    	return "connected";
    }
}
