<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasseurPost;
use Auth;

class MasseurNoticeController extends Controller
{
	public function __construct()
    {
   	   $this->middleware('auth');
   	   $this->middleware('masseur');
    }

    public function index(){
    	$ads = MasseurPost::all();
    	return view('masseurs_ads.index')->with('ads',$ads);
    }


    public function create(){
    	return view('masseurs_ads.create');
    }

    public function store(Request $request){
    	$masseur_post = new MasseurPost();
    	$data = $this->validate($request,[
    		'title'=>'required|max:100',
    		'description'=>'required',
    		'company'=>'required',
    		'where'=>'required'
    	]);

    	$masseur_post->user_id = Auth::id();

    	$masseur_post->title = $data['title'];
    	$masseur_post->description = $data['description'];
    	$masseur_post->company = $data['company'];
    	
    	if(isset($data['area']))
    	{
    		$masseur_post->area = $data['area'];
    	}
    	if(isset($data['city']))
    	{
    		$masseur_post->city = $data['city'];
    		$masseur_post->province = $data['province'];
    		$masseur_post->street = $data['street'];
    		$masseur_post->number = $data['number'];
    	}


    	$masseur_post->save();

    	return 'success';



    	// $mtc_data = json_decode($request->mtc_data,true);

    	// return $request->area;
    }
}
