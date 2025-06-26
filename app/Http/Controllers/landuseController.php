<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\city;
use App\Models\comment;
use App\Models\consult;
use App\Models\course;
use App\Models\landuse;
use App\Models\multimedia;
use App\Models\requirement;
use App\Models\state;
use App\Models\wikiidea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class landuseController extends Controller
{
  protected  $accessdenide_response = [
    'error' => true,
    'data' => '',
    'message' => 'شما مجوز این عملیات را ندارید',
    'type' => 'error'
  ];

  public function landuse()
  {
    $landuses=landuse::where("isOnlyState","=",1)->get();
    return view('landuse.landuse',compact("landuses"));
  }

  public function landusecity($id,$name =null)
  {
    $landinfo=landuse::where("id_city","=",$id)->where("isOnlyState","<>",1)->first();

    $landcity=[];
    $landmedia=[];
    $reqs=[];
    $courses=[];
    $ideas=[];
    $state=$name;

    if ($landinfo != null) {

      if($landinfo->view_count>=0)
        $landinfo->increment('view_count');
      else{
        $landinfo->view_count=0;
        $landinfo->save();
      }

//                $state = $landinfo->state;
      $landcity = [];
      $landmedia = multimedia::where("type", "=", "landuse")
        ->where("id_target", "=", $landinfo->id)
        ->get();

      $courses = course::where('id_state', '=', $landinfo->id_state)
        ->orWhere('memo', 'like', '%' . $landinfo->state . '%')
        ->get();

      $ideas = wikiidea::where('state', '=', $landinfo->state)
        ->orWhere('memo', 'like', '%' . $landinfo->state . '%')
        ->get();
    }

    return view('landuse.landuseitem',compact('landinfo','landcity','landmedia','courses','ideas','state'));

  }

  public function landuseitem($classname)
  {
    $landinfo=landuse::where("classname","=",$classname)->first();
    $landcity=[];
    $landmedia=[];
    $reqs=[];
    $courses=[];
    $ideas=[];
    $consults =[];
    $state="";
    if ($landinfo != null) {

      if($landinfo->view_count>=0)
        $landinfo->increment('view_count');
      else{
        $landinfo->view_count=0;
        $landinfo->save();
      }


      $state = $landinfo->state;
      $landcity = city::where("state_id", "=", $landinfo->id_state)->get();
      $landmedia = multimedia::where("type", "=", "landuse")
        ->where("id_target", "=", $landinfo->id)
        ->get();

      $courses = course::where('id_state', '=', $landinfo->id_state)
        ->orWhere('memo', 'like', '%' . $landinfo->state . '%')
        ->select('id','title','have_certificate','abstractMemo','view_count','code','image','minutes','hour','price','old_price','discount','register_count','id_teacher','score')
        ->get()
        ->take(10);


      $ideas = wikiidea::where('id_state', '=', $landinfo->id_state)
        ->orWhere('memo', 'like', '%' . $landinfo->state . '%')
        ->select('id','title','abstractMemo','view_count','code','image','registe_date')
        ->get();

      $consults = consult::where('id_state', '=', $landinfo->id_state)
        ->select('id','fullname','consult_count','score','consult_field','code','image','view_count','like_count','comment_count')
        ->get()
        ->take(8);


    }

    return view('landuse.landuseitem',compact('landinfo','landcity','landmedia','courses','ideas','state','consults'));

  }

  public function landuses()
  {
    if(auth()->user()->can('view-landuse')) {

      $landuse= landuse::all();
      $landuse_count=$landuse->count();
      $landuse_view_count = $landuse->sum('view_count');
      $landuse_like_count = $landuse->sum('like_count');
      $comment_count = comment::where("type", "=", "landuse")->count();

      return view("_manager.landuse.landuses", compact("landuse_count", "landuse_view_count", "landuse_like_count", "comment_count"));
    }
    else
      return view("_manager.accessdenid");
  }

  public function all_landuses()
  {
    if(auth()->user()->can('view-landuse')) {
      $per_delete = auth()->user()->can('delete-landuse');
      return Datatables::of(landuse::where("id",">=",0)->select("id","code","image","id_state","id_city","abstract","view_count","like_count","status"))
        ->addColumn('state', function ($row) {
          return $row->getStateName();
        })->addColumn('city', function ($row) {
          return $row->getCityName();
        })->addColumn('per_delete', function ($row) use ($per_delete) {
          return $per_delete;
        })
        ->make(true);
    }
    else
      return "";
  }

  public function add_form()
  {
    if (auth()->user()->can('create-landuse')){
      $states = getState();
      $files=[];
      $dir='';
      return view("_manager.landuse.add_landuse", compact("states","files","dir"));
    }
    else{
      return view("_manager.accessdenid");
    }
  }

  public function add_landuse(Request $request)
  {
    if (auth()->user()->can('create-landuse')){
      $cloud_url = $request->landuse_cloud_url;
      $state = $request->state;
      $city = $request->city;
      $population = $request->population;
      $area = $request->area;
      $abstract = $request->landuse_abstract;
      $memo = $request->landuse_memo;
      $landuse_jobs_score = $request->landuse_jobs_score;
      $landuse_jobs_prority = $request->landuse_jobs_prority;
      $isOnlyState = $request->isOnlyState;
      $code = generateIdeaCode();

      $imgFileName='';
      if ($request->file('landuse_image')) {
        $folderPath = "_upload_/_landuse_/" . $code;
        $imgFileName = uploadImageFile($request->file('landuse_image'), $folderPath);
      }

      $state_info=state::where("id","=",$state)->first();
      $state_name=$state_info->name;
      $classname=$state_info->classname;
      $landuse = new landuse();
      $landuse->code = $code;
      $landuse->name = $state_name;
      $landuse->classname = $classname;
      $landuse->cloud_url = $cloud_url;
      $landuse->id_state = $state;
      $landuse->state = $state_name;
      $landuse->id_city = $city;
      $landuse->area = $area;
      $landuse->population = $population;
      $landuse->image = $imgFileName;
      $landuse->abstract = $abstract;
      $landuse->isOnlyState = $isOnlyState;
      $landuse->view_count = 1;
      $landuse->like_count = 1;
      $landuse->comment_count = 0;
      $landuse->regist_date = nowDate_Shamsi();
      $landuse->content = $memo;
      $landuse->jobs_prority = $landuse_jobs_prority;
      $landuse->jobs_score = $landuse_jobs_score;
      $landuse->save();

      return ($this->ajax_response(false,$landuse,'ثبت آمایش با موفقیت انجام شد','success'));
    }
    else
      return response()->json($this->accessdenide_response);
  }

  public function delete_landuse(Request $request)
  {
    if (auth()->user()->can('delete-landuse')) {

      $id = $request->id;


      $landuse=landuse::where("id", "=", $id)->first();
      $path="_upload_/_landuse_/".$landuse->code;
      delete_directory($path);
      $landuse->delete();

      return ($this->ajax_response(false,'','حذف آمایش سرزمینی با موفقیت انجام شد','success'));

    }
    else
      return response()->json($this->accessdenide_response);


  }

  public function edit_landuse(Request $request)
  {

    if (auth()->user()->can('edit-landuse')) {

      $cloud_url = $request->landuse_cloud_url;
      $state = $request->state;
      $city = $request->city;
      $population = $request->population;
      $area = $request->area;
      $abstract = $request->landuse_abstract;
      $memo = $request->landuse_memo;
      $id_landuse=$request->landuse_id;
      $isOnlyState=$request->isOnlyState;
      $landuse_jobs_score = $request->landuse_jobs_score;
      $landuse_jobs_prority = $request->landuse_jobs_prority;
      $landuse = landuse::where("id", "=", $id_landuse)->first();


      $imgFileName='';
      if ($request->file('landuse_image')) {
        $folderPath = "_upload_/_landuse_/" .$landuse->code;

        deleteFile($folderPath.'/'.$landuse->image);
        deleteFile($folderPath.'/medium_'.$landuse->image);
        deleteFile($folderPath.'/small_'.$landuse->image);


        $imgFileName = uploadImageFile($request->file('landuse_image'), $folderPath);
        $landuse->image=$imgFileName;
      }

      $state_info=state::where("id","=",$state)->first();
      $state_name=$state_info->name;
      $classname=$state_info->class;

      $landuse->cloud_url = $cloud_url;
      $landuse->id_state = $state;
      $landuse->state = $state_name;
      $landuse->classname = $classname;
      $landuse->id_city = $city;
      $landuse->population = $population;
      $landuse->area = $area;
      $landuse->abstract = $abstract;
      $landuse->isOnlyState = $isOnlyState;
      $landuse->content = $memo;
      $landuse->jobs_prority = $landuse_jobs_prority;
      $landuse->jobs_score = $landuse_jobs_score;
      $landuse->save();

      return ($this->ajax_response(false,'','ثبت تغییرات آمایش سرزمینی با موفقیت انجام شد','success'));

    }
    else
      return response()->json($this->accessdenide_response);
  }

  public function view_landuse($id,$title)
  {
    if (auth()->user()->can('view-landuse')){

      $landuse = landuse::where("id", "=", $id)->first();
      Session::forget('state');

      $states = getState();
      $images =multimedia::where("type","=","landuse")->where("id_target","=",$id)->get();

      if ($landuse != '' && $landuse != null)
        return view("_manager.landuse.detail_landuse", compact("landuse", "images", "states"));
      else {
        $message = "آمایش سرزمینی مورد نظر یافت نشد";
        $backUrl = '_manager/landuses';
        return view("_manager.message", compact("message", "backUrl"));
      }
    }
    else
      return view("_manager/accessdenid");

  }

  public function up_to_gallery_landuse(Request $request)
  {
    if (auth()->user()->can('edit-landuse')) {

      $id_landuse = $request->landuse_id;

      if ($request->file('landuse_image_gallery')) {
        $landuse = landuse::where("id", "=", $id_landuse)->first();
        $folderPath = "_upload_/_landuse_/" . $landuse->code . "/images";
        $imgFileName = uploadImageFile($request->file('landuse_image_gallery'), $folderPath);
        $img = new multimedia();
        $img->type = "landuse";
        $img->id_target = $id_landuse;
        $img->file_type = "image";
        $img->file_path = $imgFileName;
        $img->caption = "آمایش سرزمینی";
        $img->save();
        $img->code=$landuse->code;

        return ($this->ajax_response(false,$img,'ثبت آمایش با موفقیت انجام شد','success'));

      }
    }
    else
      return response()->json($this->accessdenide_response);
  }

  public function delete_landuse_image(Request $request)
  {
    $landuse_id=$request->landuse_id;
    $id=$request->id;

    if(auth()->user()->can('edit-landuse')) {
      $img=multimedia::where("type","=","landuse")->where("id_target","=",$landuse_id)->where("id","=",$id)->first();
      $landuse=landuse::where("id","=",$landuse_id)->first();
      $filePath = "_upload_".DIRECTORY_SEPARATOR."_landuse_".DIRECTORY_SEPARATOR . $landuse->code . DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$img->file_path;

      deleteFile($filePath);
      $img->delete();

      return ($this->ajax_response(false,'','حذف تصویر آمایش با موفقیت انجام شد','success'));

    }
    else
      return response()->json($this->accessdenide_response);
  }

}
