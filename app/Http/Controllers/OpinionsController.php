<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Opinion;
use App\MasseurPost;
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

      if($yourOpinion = Opinion::where('masseur_post_id','=',$request['post_id'])->where('user_id','=',Auth::id())->with('user')->first())
      {

        $yourOpinion->note = $request['note'];
        $yourOpinion->opinion = $request['opinion'];
        $yourOpinion->save();
        $this->update_avg_note($request['post_id']);
        return $yourOpinion;
      }else{
        $opinion = new Opinion;
        $opinion->note = $request['note'];
        $opinion->opinion = $request['opinion'];
        $opinion->masseur_post_id = $request['post_id'];
        $opinion->user_id = Auth::id();
        $opinion->save();

        $op = Opinion::whereId($opinion->id)->with('user')->get();
        $this->update_avg_note($request['post_id']);
        return $op;
      }
    }

    private function update_avg_note($post_id)
    {
      $post = MasseurPost::find($post_id);
      $avgNote = Opinion::where('masseur_post_id','=',$post_id)->avg('note');
      $post->avg_note = round((float)$avgNote*2)/2;
      $post->save();
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
               'from' => 1,
               'to' => $opinions->lastItem()
           ],
           'data' => $opinions
       ];
      return response()->json($response);
    }
}
