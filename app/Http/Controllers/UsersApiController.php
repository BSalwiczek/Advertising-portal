<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;


class UsersApiController extends Controller
{
	public function __construct()
    {
        $this->middleware('guest');
    }

	use VerifiesEmails;
	public $successStatus = 200;
	/**
	* Register api
	*
	* @return \Illuminate\Http\Response
	*/
	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name'=>'required|string|max:30',
    		'surname'=>'required|string|max:30',
    		'email'=>'required|email|max:50|unique:users',
    		'password'=>'required|min:8|max:30',
    		'role'=>'required',
    		'accept_terms'=>'accepted',
			'password2' => 'required|same:password',
		]);

		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}
		$user = User::create([
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'role' => $request['role'],
            'profile_img' => 'default.png',
            'password' => Hash::make($request['password']),
        ]);
		$user->sendApiEmailVerificationNotification();
		$success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';

		return response()->json(['success'=>$success], $this->successStatus);
	}
	/**
	* details api
	*
	* @return \Illuminate\Http\Response
	*/
	public function details()
	{
		$user = Auth::user();
		return response()->json(['success' => $user], $this->successStatus);
	}
}