<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use mrcnpdlk\Teryt\Client;
use mrcnpdlk\Teryt\NativeApi;

use App\User;
use Auth;

class ApiController extends Controller
{
    public function getCities(Request $request){
		$this->validate($request,['input'=>'required|min:3|max:30|alpha']);
		$userInput = $request['input'];

		$login="BSalwiczek";
		$password="G#42Am9u7f";

		$oClient = new Client();
		$oClient
		        ->setConfig($login,$password,true); // not required for connect to testing database
		//         ->setCacheInstance($oInstanceCacheRedis)
		//         ->setLoggerInstance($oInstanceLogger);
		$oNativeApi = NativeApi::create($oClient);
		$miejscowosci = $oNativeApi->WyszukajMiejscowoscWRejestrze($userInput);
		if($miejscowosci == false)
			return 0;
		else
			return array_slice($miejscowosci,0,15,true);
		// if(sizeof($miejscowosci) <= 15){
		// 	if(sizeof($miejscowosci) > 0)
		// 		return $miejscowosci;
		// 	else
		// 		return 0;
		// }

		// return 1;

    }
    public function getUsers(Request $request){
		$this->validate($request,['input'=>'required|min:3|max:70|alpha']);
		$userInput = $request['input'];

		$users=User::where('name','like','%' . $userInput . '%')->where('id','!=',Auth::id())->orWhere('surname','like','%' . $userInput . '%')->get();
    $user_data = [];
    foreach ($users as $key => $user) {
      array_push($user_data,[
        'name'=>$user->name,
        'surname'=>$user->surname,
        'profile_img'=>$user->profile_img,
        'role'=>$user->role,
        'id'=>$user->id,
      ]);
    };

  		return $user_data;
  	}
        // var_dump($oNativeApi->PobierzSlownikCechULIC());
        // var_dump($oNativeApi->WyszukajMiejscowosc('skiernie',null));
}
