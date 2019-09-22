<?php

namespace App\Http\Controllers;

// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\MasseurPost;
use App\MassageType;
use App\Opinion;
use Illuminate\Support\Facades\Validator;
use Auth;
use Cookie;
use DB;


class MasseurNoticeController extends Controller
{
    public function __construct()
    {
        // Middleware only applied to these methods
        $this->middleware('masseur', ['only' => [
            'create','getRelatedSlugs','createSlug','store'
        ]]);
        $this->middleware('auth', ['only' => [
            'create','getRelatedSlugs','createSlug','store'
        ]]);
    }
    public function index(Request $request){
        $this->validate($request,[
            'uc'=>'sometimes|numeric', //Information that user changed filters
            'to_client'=>'sometimes',
            'to_masseur'=>'sometimes',
            'masseur_note'=>'sometimes|numeric|lt:6',
            'masseur_notes_count'=>'sometimes|numeric|lt:11',
            'masseur_opinions_count'=>'sometimes|numeric',
            'city'=>'sometimes|alpha',
        ]);
        $request_copy = $request;
        if(!isset($request_copy['uc'])){
            if(!isset($request_copy['to_client']))
                $request_copy['to_client'] = true;
            if(!isset($request_copy['to_masseur']))
                $request_copy['to_masseur'] = true;
        }
        // dd($request_copy->all());

        //=========================Create query=========================
        if(isset($request_copy['city'])){
            $query_obj = MasseurPost::whereRaw('LOWER(`city`) LIKE ? ',[strtolower($request_copy['city'])]);
        }
        else{
            $query_obj = MasseurPost::where('name','!=',null);

        }

        if(isset($request_copy['to_client']) and !isset($request_copy['to_masseur']))
        {
            $query_obj = $query_obj->where('area','!=',null);
        }else if(isset($request_copy['to_masseur']) and !isset($request_copy['to_client'])){
            $query_obj = $query_obj->where('city','!=',null);
        }else if(!isset($request_copy['to_masseur']) and !isset($request_copy['to_client'])){
            $query_obj = MasseurPost::where('id','<',0); //select none
        }


        if(isset($request['price_enabled']))
        {
            $from = $request['from_price'];
            $to = $request['to_price'];
            $query_obj = $query_obj->whereHas('massagetypes', function($query) use($to,$from){
                $query->where('price','>=',$from)->where('price','<=',$to);
            });
            // $query_obj = $query_obj->whereHas('massagetypes')
        }

        if(isset($request['masseur_note']))
        {
          $query_obj = $query_obj->where('avg_note','>=',$request['masseur_note']);
        }

        if(isset($request['masseur_opinions_count']))
        {
          $query_obj = $query_obj->withCount('opinions')->has('opinions','>=',$request['masseur_opinions_count']);
        }

        if(isset($request['sorting']))
        {
            $sorting = $request['sorting'];
            if($sorting == 0){
                $query_obj = $query_obj->orderBy('created_at','desc');
            }else if($sorting == 1){
                $query_obj = $query_obj->orderBy('created_at','asc');
            }else if($sorting == 2){
                $query_obj = $query_obj->orderByJoin('massagetypes.price');
            }else if($sorting == 3){
                $query_obj = $query_obj->orderByJoin('massagetypes.price','desc');
            }else if($sorting == 4){
                $query_obj = $query_obj->withCount('opinions')->orderBy('opinions_count','desc');
            }else if($sorting == 5){
                $query_obj = $query_obj->orderBy('avg_note','desc');
            }
        }else{
            $query_obj = $query_obj->orderBy('created_at','desc');
        }

        $count = count($query_obj->get());
        $ads = $query_obj->withCount('opinions')->paginate(15);

        //get averege notes
        // $x = $query_obj->with('opinions')->paginate(15);
        // $avg_note = [];
        // foreach ($x as $key => $value) {
        //   array_push($avg_note,round($value->opinions->avg('note')*2)/2);
        // }
        // dd($avg_note);
        //todo: każdy masażysta może dodać 1 posta, dodać do migracji kolumnę średnia ocena

        // $currentPage = 1;
        // if(isset($request['page'])){
        //     $currentPage=$request['page'];
        // }
        // \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
        //     return $currentPage;
        // });





        // //=========================GET PRICES=========================
        $prices_arr = array();
        foreach ($ads as $key => $ad) {
            array_push($prices_arr,[]);
                foreach($ad->massagetypes as $msg_type){
                    if(sizeof($prices_arr[$key]) == 0)
                        array_push($prices_arr[$key],$ad->id);
                    array_push($prices_arr[$key],$msg_type->price);
            }
        }
        $prices = json_encode($prices_arr);


        // dd($ads[0]->massagetypes[0]->price);
    	return view('masseurs_ads.index')->with('ads',$ads)->with('posts_count',$count)->with('prev_data',json_encode($request_copy->all()))->with('prices',$prices);
    }
    public function show($slug){
    	$post = MasseurPost::where('slug',$slug)->firstOrFail();
      $massage_types = MassageType::where('masseur_post_id',$post->id)->get();
      $opinion = Opinion::where('masseur_post_id','=',$post->id)->where('user_id','=',Auth::id())->first();

      $opinions_count = Opinion::where('masseur_post_id','=',$post->id)->count();
      $opinions_average = round(Opinion::where('masseur_post_id','=',$post->id)->avg('note') * 2)/2;

      return view('masseurs_ads.show')->withPost($post)->with('massage_types',$massage_types)->withOpinion($opinion)->with('averageNote',$opinions_average)->with('notesCount',$opinions_count);
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
            return 'Zdjęcia które przesałałeś są niepoprawne. Upewnij się, że zdjęcia mają poniżej 4mb i są formatu jpeg,png,jpg,gif lub svg';
        }

        // dd($rules);

        // dd($request->files->all());

        // $images_validator = Validator::make($request->images,[
        // ]);

        if(MasseurPost::where('user_id','=',Auth::id())->first())
          return 0;

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
