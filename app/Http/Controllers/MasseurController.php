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
    public function index(Request $request){
      $data = $this->validate($request,[
        'option'=>'sometimes|numeric',
        'friendId'=>'sometimes|numeric'
      ]);
      $option = 0;
      $friend_data = array();
      if(isset($data['option']))
        $option = $data['option'];
      $friendId = -1;
      if(isset($data['friendId'])){
        if((int)$data['friendId'] !== Auth::id()){
          $friendId = $data['friendId'];
          $friend = User::findOrFail((int)$friendId);
          array_push($friend_data,[
            'name'=>$friend->name,
            'surname'=>$friend->surname,
            'profile_img'=>$friend->profile_img,
            'role'=>$friend->role,
            'id'=>$friend->id,
          ]);
        }
      }
    	return view('masseur.index')->with('option',$option)->with('friend_id',$friendId)->with('friend_data',json_encode($friend_data));
    }

    public function getAdData(){
      // return Auth::user()->with('MasseurPost')->get();
      return Auth::user()->masseurpost;
    }
}
