<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use mrcnpdlk\Teryt\Client;
use mrcnpdlk\Teryt\NativeApi;

class ApiController extends Controller
{
    public function getCities(Request $request){
		$this->validate($request,['input'=>'required|min:3|max:30|alpha']);
		$userInput = $request['input'];

		// $login="TestPubliczny";
		//    $password="1234abcd";

		$oClient = new Client();
		// $oClient
		//         ->setConfig($login,$password,true) // not required for connect to testing database
		//         ->setCacheInstance($oInstanceCacheRedis)
		//         ->setLoggerInstance($oInstanceLogger);
		$oNativeApi = NativeApi::create($oClient);
		$miejscowosci = $oNativeApi->WyszukajMiejscowoscWRejestrze($userInput);
		if(sizeof($miejscowosci) <= 15){
			if(sizeof($miejscowosci) > 0)
				return $miejscowosci;
			else
				return 0;
		}

		return 1;

    }
        // var_dump($oNativeApi->PobierzSlownikCechULIC());
        // var_dump($oNativeApi->WyszukajMiejscowosc('skiernie',null));
}
