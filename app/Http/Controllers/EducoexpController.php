<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;
use App\Educoexp;

class EducoexpController extends Controller
{
  public function index(){
    $user = Auth::user();
    $user->load('educoexps');
    return $user;
  }
  public function update(Request $request){

    //validation
    $validator = Validator::make($request->all(), [
        'name'=>'required|string|max:30|alpha',
        'surname'=>'required|string|max:30|alpha',
    ]);
    $eduValidator = Validator::make($request->education,[
      '*.since'=>'required|max:16',
      '*.to'=>'sometimes|nullable|max:16',
      '*.description'=>'required|max:255',
    ]);
    $coValidator = Validator::make($request->courses,[
      '*.since'=>'required|max:16',
      '*.to'=>'sometimes|nullable|max:16',
      '*.description'=>'required|max:255',
    ]);
    $expValidator = Validator::make($request->experience,[
      '*.since'=>'required|max:16',
      '*.to'=>'sometimes|nullable|max:16',
      '*.description'=>'required|max:255',
    ]);
    if ($validator->fails()) {
      return response()->json(['error'=>$validator->errors()], 401);
    }
    if ($eduValidator->fails()) {
      return response()->json(['error'=>$eduValidator->errors()], 401);
    }
    if ($coValidator->fails()) {
      return response()->json(['error'=>$coValidator->errors()], 401);
    }
    if ($expValidator->fails()) {
      return response()->json(['error'=>$expValidator->errors()], 401);
    }

    //update user information
    $user = User::find(Auth::id());
    $user->name=$request['name'];
    $user->surname=$request['surname'];
    $user->educoexps()->delete();
    $user->save();

    //update education, courses and experience
    foreach ($request->education as $key => $value) {
      $education = new Educoexp();
      $education->category = 'education';
      $education->user_id = Auth::id();
      $education->since = $value['since'];
      $education->to = $value['to'];
      $education->description = $value['description'];
      $education->save();
    }
    foreach ($request->courses as $key => $value) {
      $courses = new Educoexp();
      $courses->category = 'courses';
      $courses->user_id = Auth::id();
      $courses->since = $value['since'];
      $courses->to = $value['to'];
      $courses->description = $value['description'];
      $courses->save();
    }
    foreach ($request->experience as $key => $value) {
      $experience = new Educoexp();
      $experience->category = 'experience';
      $experience->user_id = Auth::id();
      $experience->since = $value['since'];
      $experience->to = $value['to'];
      $experience->description = $value['description'];
      $experience->save();
    }

    return 'success';
  }
}
