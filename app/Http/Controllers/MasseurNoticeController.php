<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasseurPost;
use App\MassageType;
use Illuminate\Support\Facades\Validator;
use Auth;
use Cookie;

class MasseurNoticeController extends Controller
{
    public function __construct()
    {
        // Middleware only applied to these methods
        $this->middleware('masseur', ['only' => [
            'create','getRelatedSlugs','createSlug','store' // Could add bunch of more methods too
        ]]);
        $this->middleware('auth', ['only' => [
            'create','getRelatedSlugs','createSlug','store' // Could add bunch of more methods too
        ]]);
    }
    public function index(){
    	$ads = MasseurPost::orderBy('created_at','desc')->paginate(15);
        $count = count(MasseurPost::all());
    	return view('masseurs_ads.index')->with('ads',$ads)->with('posts_count',$count);
    }
    public function show($slug){
    	$post = MasseurPost::where('slug',$slug)->firstOrFail();
        $massage_types = MassageType::where('masseur_post_id',$post->id)->get();
        return view('masseurs_ads.show')->withPost($post)->with('massage_types',$massage_types);
    }
    public function gotoads(){
        //create added_post cookie
        $cookie = Cookie::queue('added_post',true,2);
        return redirect()->route('masazysci');
    }
    public function create(){
        return view('masseurs_ads.create');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return MasseurPost::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    public function store(Request $request){

        $data = $this->validate($request,[
            'title'=>'required|max:100',
            'description'=>'required',
            'company'=>'required',
            'where'=>'required',
            'area'=>'sometimes|required',
            'province'=>'sometimes|required',
            'street'=>'sometimes|required',
            'number'=>'sometimes|required|numeric',
            'city'=>'sometimes|required',
        ]);

        $mtc_validator = Validator::make(json_decode($request->mtc_data,true),[
            '*.name'=>'required',
            '*.description'=>'required',
            '*.price'=>'numeric',
            '*.duration'=>'required',
        ]);

        if ($mtc_validator->fails()) {
            return 'Wystąpił błąd w danych o typach masażu';
        }

        //photos validation
        $rules = [];
        foreach ($request->files->all() as $image => $value) {
            $rules[$image] = 'image|mimes:jpeg,png,jpg,gif,svg|max:4096';
        }
        $files_validator = Validator::make($request->files->all(),$rules);
        if ($files_validator->fails()) {
            return 'Zdjęcie które przesałałeś jest niepoprawne. Upewnij się, że zdjęcia mają poniżej 4mb i są formatu jpeg,png,jpg,gif lub svg';
        }

        // dd($rules);

        // dd($request->files->all());

        // $images_validator = Validator::make($request->images,[
        // ]);

        //post
        $masseur_post = new MasseurPost();
        $masseur_post->user_id = Auth::id();

        $masseur_post->title = $data['title'];
        $masseur_post->description = $data['description'];
        $masseur_post->company = $data['company'];

        $masseur_post->slug = $this->createSlug($data['title']);
        
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

        //images
        $names = [];
        foreach ($request->files->all() as $image => $value) {
            $names[$image] = $request->file($image)->store('/public/massage_types');
        }

        // dd($names);

        // massage type
        $mtc_data_json = $request->mtc_data;
        $mtc_data = json_decode(strval($mtc_data_json));
        

        foreach ($mtc_data as $type) {
            $massage_type = new MassageType();
            $massage_type->masseur_post_id = $masseur_post->id;
            $massage_type->name = $type->name;
            $massage_type->description = $type->description;
            $massage_type->price = $type->price;
            $massage_type->duration = $type->duration;
            if(isset($names['image'.$type->id])){
                $massage_type->img_name = $names['image'.$type->id];
            }else{
                $massage_type->img_name = "/public/massage_types/classic.jpg";
            }
            
            $massage_type->save();
        }


        return 'success';

        // return $mtc_data;



        // $mtc_data = json_decode($request->mtc_data,true);

        // return $request->area;
    }

}
