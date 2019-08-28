<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasseurPost;
use Auth;
use Validator;
use App\User;

class MasseurController extends Controller
{
    public function __construct()
    {
   	   $this->middleware('auth');
   	   $this->middleware('masseur');
    }
    public function index(){
    	return view('masseur.index');
    }

    public function update(Request $request){
    	$validator = Validator::make($request->all(), [
			'name'=>'required|string|max:30|alpha',
    		'surname'=>'required|string|max:30|alpha',
		]);

		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}

		$user = User::find(Auth::id());
		$user->name=$request['name'];
		$user->surname=$request['surname'];
		$user->save();

		return 'success';
    }
}
