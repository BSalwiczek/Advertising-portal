<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Opinion;
use Auth;

class OpinionsController extends Controller
{
    public function store(Request $request)
    {
      $this->validate($request,[
        'note'=>'required|numeric',
        'opinion'=>'sometimes|max:3000',
        'post_id'=>'required|numeric',
      ]);
      $opinion = new Opinion;
      $opinion->note = $request['note'];
      $opinion->opinion = $request['opinion'];
      $opinion->masseur_post_id = $request['post_id'];
      $opinion->user_id = Auth::id();
      $opinion->save();

      $op = Opinion::whereId($opinion->id)->with('user')->get();

      return $op;
    }


    public function index(Request $request){
      $this->validate($request,[
        'post_id'=>'required|numeric',
      ]);
      $opinions = Opinion::where('masseur_post_id','=',$request['post_id'])->with('user')->orderBy('created_at','desc')->paginate(10);
      $response = [
           'pagination' => [
               'total' => $opinions->total(),
               'per_page' => $opinions->perPage(),
               'current_page' => $opinions->currentPage(),
               'last_page' => $opinions->lastPage(),
               'from' => $opinions->firstItem(),
               'to' => $opinions->lastItem()
           ],
           'data' => $opinions
       ];
      return response()->json($response);
    }
}
