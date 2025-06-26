<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\comment;
use App\Models\like;
use App\Models\state;
use App\Models\User;
use App\Models\wikiidea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class wikiController extends Controller
{

  protected  $accessdenide_response = [
    'error' => true,
    'data' => '',
    'message' => 'شما مجوز این عملیات را ندارید',
    'type' => 'error'
  ];

  public function wikiidea () {
    $cats = getCategory('idea');

    $comments = comment::where([['status', 1], ['type', 'idea']])
      ->with(['user' => function ($q) {
        $q->select('id', 'name', 'image', 'code');
      }])
      ->select('id', 'id_target', 'id_user', 'score', 'regist_date', 'comment')
      ->latest('id')
      ->limit(5)
      ->get();

    $ideas = wikiidea::where('status', 1)
      ->select('id', 'title', 'image', 'code', 'minimal_fund', 'risk', 'profitability', 'id_category', 'abstractMemo', 'score', 'like_count', 'view_count', 'comment_count')
      ->limit(6)
      ->latest('id')
      ->get();

    return view('wiki.ideas-index', compact('cats', 'comments', 'ideas'));
  }

  public function wikiListCat ($title) {
    $cats = getCategory('idea');
    $title = str_replace('_', ' ', $title);
    return view('wiki.ideas-list', compact('cats', 'title'));
  }

  public function wikiListCatSearch(){
    $limit = 4;
    $query = wikiidea::where('status', 1);

    $title = request()->title;
    if($title) $query->where('id_category', $title);

    $risk = request()->risk;
    if($risk) $query->where('risk', $risk);

    $sort = request()->sort;
    if(in_array($sort, ['like_count', 'view_count']))
      $query->orderBy($sort, 'desc');
    else
      $query->orderBy('id','desc');

    $search = request()->search;
    if($search) {
      $query->where(function ($q) use ($search) {
        $q->where('title', 'LIKE', "%$search%")
          ->orWhere('abstractMemo', 'LIKE', "%$search%");
      });
    }

    $minPrice = (int)(str_replace(',','',request()->priceNumberMin));
    $maxPrice = (int)(str_replace(',','',request()->priceNumberMax));


    $query->whereBetween('minimal_fund', [$minPrice, $maxPrice]);

    $ideas = $query
      ->select('id', 'title', 'image', 'code', 'minimal_fund', 'risk', 'profitability', 'id_category', 'abstractMemo', 'score', 'like_count', 'view_count', 'comment_count','manpower')
      ->paginate($limit);

    return view('wiki.ideas-list-search', compact('ideas'));
  }

  public function wikiideaDetails ($id) {

    $idea = wikiidea::where([['status', 1], ['id', $id]])
      ->with([
        'category' => function ($q) {
          $q->select('id', 'title');
        },
        'writer' => function ($q) {
          $q->select('id', 'name', 'code', 'image', 'last_education');
        }
      ])->first();

    $comments = comment::where([['type', 'idea'], ['id_target', $id], ['status', 1]])
      ->with(['user' => function ($q) {
        $q->select('id', 'name', 'image', 'code');
      }])
      ->select('id','id_target','id_user','score','regist_date','comment')
      ->orderBy('id','desc')
      ->paginate(10);

    $related_ideas = wikiidea::where([['status', '1'], ['id', '<>', $idea->id]])
      ->whereNotNull('id_middle')->whereNotNull('id_sub')
      ->where(function ($q) use ($idea) {
        $q->where('id_middle', $idea->id_middle)
          ->orWhere('id_sub', $idea->id_sub);
      })
      ->with([
        'category' => function ($query) {
          $query->select('id', 'title');
        },'writer' => function ($query) {
          $query->select('id', 'name', 'code', 'image', 'like_count', 'last_education', 'regist_date');
        }])
      ->select('id', 'title', 'like_count', 'intro_video', 'image', 'code', 'minimal_fund', 'risk', 'profitability', 'id_category', 'abstractMemo', 'score', 'id_user', 'registe_date', 'like_count', 'view_count', 'comment_count')
      ->limit(5)
      ->get();

    $like = false;
    if(Auth::check())
      $like =like::where([['id_user', Auth::user()->id], ['type', 'idea'], ['id_target', $id]])->first();

    return view('wiki.ideas-details', compact('idea','like', 'comments', 'related_ideas'));
  }

  public function commentsDetailsSearch () {
    $id = request()->ideaId;
    $comments = comment::where([['type', 'idea'], ['id_target', $id], ['status', 1]])
      ->with(['user' => function ($q) {
        $q->select('id', 'name', 'image', 'code');
      }])
      ->select('id','id_target','id_user','score','regist_date','comment')
      ->orderBy('id','desc')
      ->paginate(5);

    return view('wiki.ideas-comments-details', compact('comments'));
  }

  public function storeComment () {
    if(!Auth::check())
      return ($this->ajax_response(true,'','برای ثبت ایده ابتدا وارد سایت شوید','error'));

    $id = request()->ideaId;
    $wiki = wikiidea::where([['status', 1], ['id', $id]])->first();
    if(!$wiki)
      return ($this->ajax_response(true,'','ایده ای یافت نشد','error'));

    $commentScore = request()->commentScore;
    if(!$commentScore || !in_array($commentScore, ['عالی','خوب','معمولی','بد','خیلی بد']))
      return ($this->ajax_response(true,'','لطفا امتیازتان را وارد کنید','error'));

    $textarea = request()->commentTextarea;
    if(empty($textarea))
      return ($this->ajax_response(true,'','لطفا نظر خود را بنویسید','error'));

    if($commentScore === 'خیلی بد')
      $score = 1;
    elseif($commentScore === 'بد')
      $score = 2;
    elseif($commentScore === 'معمولی')
      $score = 3;
    elseif($commentScore === 'خوب')
      $score = 4;
    elseif($commentScore === 'عالی')
      $score = 5;

    $comment = new comment;
    $comment->id_user = Auth::user()->id;
    $comment->type = 'idea';
    $comment->id_target = $id;
    $comment->score = $score;
    $comment->regist_date = nowDate_Shamsi();
    $comment->comment = $textarea;
    $comment->read_status = 1;
    $comment->status = 0;
    $comment->like_count = null;
    $comment->save();

    return ($this->ajax_response(false,'','نظرتان ثبت شد و بعد از تایید مدیر منتشر خواهد شد','success'));
  }

  public function storeLike()  {
    if(!Auth::check())
      return '';

    $id = request()->ideaId;
    $wiki = wikiidea::where([['status', 1], ['id', $id]])->first();
    if(!$wiki)
      return ($this->ajax_response(true,'','ایده ای یافت نشد','error'));

    $id_user = Auth::user()->id;
    $like = like::where([['type', 'idea'], ['id_target', $id], ['id_user', $id_user]])->first();
    if($like){
      $like->delete();
      $wiki->like_count = $wiki->like_count - 1;
      $wiki->save();
      $type = false;
    } else {
      $like = new like;
      $like->type = 'idea';
      $like->id_target = $id;
      $like->id_user = $id_user;
      $like->save();
      $wiki->like_count = $wiki->like_count + 1;
      $wiki->save();
      $type = true;
    }

    return ($this->ajax_response(false, $type,'اطلاعات با موفقیت ثبت شد','success'));
  }


  public function wiki_category($id_category,$title)
  {
    $cats=getCategory("idea");

    $ideas=wikiidea::where("id_category","=",$id_category)
      ->where("status","=",1)
      ->select('id','title','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','like_count','view_count','comment_count')
      ->take(20)
      ->paginate(4);
    return view("wiki/wiki_list",compact('cats','ideas'));
  }

  public function public_search(Request $request)
  {
    $wiki_title=$request->wiki_title;

    $cats=getCategory("idea");
    $ideas=wikiidea::where("status","=",1)
      ->where("title","like", "%".$wiki_title."%")
      ->orwhere("abstractMemo","like", "%".$wiki_title."%")
      ->select('id','title','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','like_count','view_count','comment_count')
      ->paginate(5);

    return view("wiki/wiki_list",compact('cats','ideas'));
  }

  public function wiki_best()
  {
    $cats=getCategory("idea");

    $ideas=wikiidea::where("status","=",1)
      ->select('id','title','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','like_count','view_count','comment_count')
      ->orderBy('like_count', 'desc')
      ->take(20)
      ->paginate(4);
    return view("wiki/wiki_list",compact('cats','ideas'));
  }

  public function wiki_share()
  {
    $cats=getCategory("idea");
    $states=getState();
    return view("wiki.share_idea",compact("cats","states"));
  }

  public function add_user_idea(Request $request)
  {
    if(Auth::check()) {
      $idea_title = $request->idea_title;
      $idea_category = $request->idea_category;
      $idea_minimal_fund = $request->idea_minimal_fund;
      $idea_risk = $request->idea_risk;
      $idea_profitability = $request->idea_profitability;
      $idea_profitability_memo = $request->idea_profitability_memo;
      $idea_manpower = $request->idea_manpower;
      $idea_scale = $request->idea_scale;
      $idea_state = $request->idea_state;
      $idea_abstractMemo = $request->idea_abstractMemo;
      $idea_memo = $request->idea_memo;
      $code = generateIdeaCode();

      $imgFileName = '';
      $videoFileName = '';
      if ($request->file('idea_image')) {
        $folderPath = "_upload_/_wikiideas_/" . $code;
        $imgFileName = uploadImageFileWithWatermark($request->file('idea_image'), $folderPath);
      }
      if ($request->file('idea_video')) {
        $folderPath = "_upload_/_wikiideas_/" . $code;
        $videoFileName = uploadVideoFile($request->file('idea_video'), $folderPath);
      }

      $idea = new wikiidea();
      $idea->code = $code;
      $idea->id_user = Auth::user()->id;
      $idea->title = $idea_title;
      $idea->id_category = $idea_category;
      $idea->minimal_fund = $idea_minimal_fund;
      $idea->risk = $idea_risk;
      $idea->profitability = $idea_profitability;
      $idea->profitability_memo = $idea_profitability_memo;
      $idea->manpower = $idea_manpower;
      $idea->scale = $idea_scale;
      $idea->memo = $idea_memo;
      $idea->abstractMemo = $idea_abstractMemo;
      $idea->publisher_name = Auth::user()->name;
      $idea->image = $imgFileName;
      $idea->intro_video = $videoFileName;
      $idea->state = $idea_state;
      $idea->registe_date = nowDate_Shamsi();
      $idea->memo = $idea_memo;
      $idea->status = 0;
      $idea->save();

      $cat = category::where("type", "=", "idea")->where("id", "=", $idea_category)->first();

      if($cat->item_count>=0)
        $cat->increment('item_count');
      else
      {
        $cat->item_count=0;
        $cat->save();
      }

      return ($this->ajax_response(false,'','ایده ثبت و بعد از تایید منتشر خواهد شد','success'));

    }
    else
      return ($this->ajax_response(true,'','برای ثبت ایده ابتدا وارد سایت شوید','error'));

  }

  public function wiki_view()
  {
    $cats=getCategory("idea");

    $ideas=wikiidea::where("status","=",1)
      ->select('id','title','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','like_count','view_count','comment_count')
      ->orderBy('view_count', 'desc')
      ->take(20)
      ->paginate(4);
    return view("wiki/wiki_list",compact('cats','ideas'));
  }

//    public function wikiidea()
//    {
//        $cats=getCategory("idea");
//
//        $ideas=wikiidea::where("status","=",1)
//            ->select('id','title','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','like_count','view_count','comment_count')
//            ->take(20)
////            ->orderBy("id","desc")
//            ->paginate(5);
//        return view("wiki/wiki_list",compact('cats','ideas'));
//    }

  public function search_idea_ajax(Request $request)
  {
    $idea_name=$request->idea_name;

    $ideas = wikiidea::where('status', '=', 1)
      ->where('title','like','%'.$idea_name.'%')
      ->with(array('category'=>function($query){
        $query->select('id','title');
      }))
      ->select('id','title','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','like_count','view_count','comment_count')
      ->orderBy('id', 'desc')
      ->get();

    return ($this->ajax_response(false,$ideas,'','success'));

  }

  public function filter_idea_ajax(Request $request)
  {
    $min_price=(int)$request->min_price;
    $max_price=(int)$request->max_price;
    $level1=(int)$request->level1;
    $level2=(int)$request->level2;
    $level3=(int)$request->level3;
    $level4=(int)$request->level4;
    $cats=$request->cats;
    if($cats != null)
      $id_categorys = array_map('intval', explode(',', $cats));
    else
      $id_categorys=null;

    $query = wikiidea::where('status', '=', 1)
      ->with(array('category'=>function($query){
        $query->select('id','title');
      }));


    if (count($id_categorys)>0)
      $query = $query->whereIn('id_category', $id_categorys);

    $query = $query->where('minimal_fund', ">=",intval($min_price));
    $query = $query->where('minimal_fund', "<=",$max_price);

    if($level1==1)
      $query = $query->orwhere('risk',"=", "پایین");
    if($level2==1)
      $query = $query->orwhere('risk',"=", "متوسط");
    if($level3==1)
      $query = $query->orwhere('risk',"=", "زیاد");
    if($level4==1)
      $query = $query->orwhere('risk',"=", "خیلی زیاد");


    $query=$query->select('id','title','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','like_count','view_count','comment_count')->orderBy('id', 'desc');

    return ($this->ajax_response(false,$query->get(),'','success'));

  }

  public function wiki_writer($id_writer,$title=null)
  {
    $cats=getCategory("idea");

    $ideas=wikiidea::where("status","=",1)
      ->where("id_user","=",$id_writer)
      ->select('id','title','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','view_count','like_count','comment_count')
      ->take(20)
      ->paginate(5);

    return view("wiki/wiki_list",compact('cats','ideas'));
  }

  public function idea_detail($id_idea,$title=null)
  {
    $idea=wikiidea::with(array('category'=>function($query){
      $query->select('id','title');
    }))->with(array('writer'=>function($query){
      $query->select('id','name','code','image','last_education');
    }))->where('status','=',1)
      ->where('id','=',$id_idea)
      ->first();

    if($idea->view_count>=0)
      $idea->increment('view_count');
    else{
      $idea->view_count=0;
      $idea->save();
    }
    $category_title=category::where("id","=",$idea->id_category)->first()->title;

    $comments=comment::where("type","=","idea")
      ->where("id_target","=",$id_idea)
      ->where("status","=",1)
      ->with(array('user'=>function($queryuser){
        $queryuser->select('id','name','image');
      }))
      ->select('id','id_target','id_user','score','regist_date','comment')
      ->orderBy("id","desc")
      ->paginate(10);


    $related_ideas=wikiidea::where('status','=','1')
      ->where('id_category','=',$idea->id_category)
      ->where('id','<>',$idea->id)
      ->with(array('category'=>function($query){
        $query->select('id','title');
      }))->with(array('writer'=>function($query){
        $query->select('id','name','code','image','like_count','last_education','regist_date');
      }))
      ->select('id','title','like_count','intro_video','image','code','minimal_fund','risk','profitability','id_category','abstractMemo','score','id_user','registe_date','like_count','view_count','comment_count')
      ->take(5)
      ->get();



    $user_ideas=wikiidea::where("id_user","=",$idea->id_user)
      ->with(array('category'=>function($query){
        $query->select('id','title');
      }))->where('status','=','1')
      ->select('id','title','code','image','registe_date','like_count','view_count','comment_count','id_category','id_user')
      ->orderBy('id','desc')
      ->take(5)
      ->get();

    return view("wiki/wikii_detail",compact('idea','user_ideas','category_title','comments','related_ideas'));
  }

  public function wikiideas()
  {
    if(auth()->user()->can('viewItem-wiki')) {
      $wiki_count = wikiidea::all()->count();
      $wiki_view_count = wikiidea::where("status", "=", 1)
        ->sum('view_count');

      $wiki_like_count = wikiidea::where("status", "=", 1)
        ->sum('like_count');

      $comment_count = comment::where("type", "=", "idea")->count();

      $idea_cats = getCategory('idea');
      $cats_count = count($idea_cats);
      return view("_manager.wiki.wikiideas", compact("wiki_count", "wiki_view_count", "wiki_like_count", "comment_count", "cats_count"));
    }
    else
      return view("_manager/accessdenid");
  }

  public function all_ideas()
  {
    if(auth()->user()->can('viewItem-wiki')) {
      $per_delete = auth()->user()->can('delete-wiki');
      return Datatables::of(wikiidea::where("id",">",0)->select('id','code','image','publisher_name','title','id_category','id_user','risk','minimal_fund','profitability','status'))
        ->addColumn('category_title', function ($row) {
          return $row->getCategoryTitle();
        })->addColumn('per_delete', function ($row) use ($per_delete) {
          return $per_delete;
        })
        ->make(true);
    }
    else{
      return "";
    }
  }

  public function consult_comments()
  {
    if (auth()->user()->can('comment-wiki')){

      $comments = comment::where("type", "=", "consult");

      $comment_count=$comments->count();

      $up_count=$comments->where("score","=",5)->count();

      $down_count=$comments->where("score","=",5)->count();

      $mean_count=0;
      if($comment_count>0)
        $mean_count=($comments->sum("score") / $comment_count);


      return view("_manager.consult.comments", compact("comment_count", "up_count", "down_count", "mean_count"));
    }
    else
      return view("_manager/accessdenid");
  }

  public function all_consult_comments()
  {
    if (auth()->user()->can('comment-wiki')){
      return Datatables::of(comment::where("type","=","consult"))
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })
        ->addColumn('consult_name', function ($row) {
          return $row->getConsultName();
        })->make(true);
    }
    else
      return "";
  }

  public function add_form()
  {
    if (auth()->user()->can('create-wiki')){
      $cats = getCategory('idea');
      $states = getState();
      return view("_manager.wiki.add_idea", compact("cats", "states"));
    }
    else{
      return view("_manager.accessdenid");
    }
  }

  public function add_idea(Request $request)
  {
    if (auth()->user()->can('create-wiki')){

      $idea_cloud_url = $request->idea_cloud_url;
      $idea_title = $request->idea_title;
      $idea_category = $request->idea_category;
      $idea_minimal_fund = $request->idea_minimal_fund;
      $idea_risk = $request->idea_risk;
      $idea_profitability = $request->idea_profitability;
      $idea_profitability_memo = $request->idea_profitability_memo;
      $idea_manpower = $request->idea_manpower;
      $idea_scale = $request->idea_scale;
      $idea_state = $request->idea_state;
      $idea_abstractMemo = $request->idea_abstractMemo;
      $idea_memo = $request->idea_memo;
      $code = generateIdeaCode();

      $imgFileName = '';
      $videoFileName = '';
      if ($request->file('idea_image')) {
        $folderPath = "_upload_/_wikiideas_/" . $code;
        $imgFileName = uploadImageFileWithWatermark($request->file('idea_image'), $folderPath);
      }
      if ($request->file('idea_video')){
        $folderPath = "_upload_/_wikiideas_/" . $code;
        $videoFileName = uploadVideoFile($request->file('idea_video'), $folderPath);
      }

      $idea = new wikiidea();
      $idea->code = $code;
      $idea->id_user = Auth::user()->id;
      $idea->title = $idea_title;
      $idea->id_category = $idea_category;
      $idea->minimal_fund = $idea_minimal_fund;
      $idea->risk = $idea_risk;
      $idea->profitability = $idea_profitability;
      $idea->profitability_memo = $idea_profitability_memo;
      $idea->manpower = $idea_manpower;
      $idea->scale = $idea_scale;
      $idea->memo = $idea_memo;
      $idea->abstractMemo = $idea_abstractMemo;
      $idea->publisher_name =  Auth::user()->name;
      $idea->image = $imgFileName;
      $idea->intro_video = $videoFileName;
      $idea->cloud_url = $idea_cloud_url;
      $idea->state = $idea_state;
      $idea->registe_date = nowDate_Shamsi();
      $idea->memo = $idea_memo;
      $idea->save();

      $cat=category::where("type","=","idea")->where("id","=",$idea_category)->first();

      if($cat->item_count>=0)
        $cat->increment('item_count');
      else{
        $cat->item_count=0;
        $cat->save();
      }

      return ($this->ajax_response(false,'','ثبت ایده با موفقیت انجام شد','success'));
    }
    else
      return response()->json($this->accessdenide_response);
  }

  public function delete_idea(Request $request)
  {
    if (auth()->user()->can('delete-wiki')) {

      $id = $request->id;
      $idea=wikiidea::where("id", "=", $id)->first();
      if($idea != null){
        $folderPath = "_upload_/_wikiideas_/" . $idea->code;
        delete_directory($folderPath);
      }

      $idea->delete();

      return ($this->ajax_response(false,'','حذف ایده با موفقیت انجام شد','success'));


    }
    else
      return response()->json($this->accessdenide_response);


  }

  public function edit_idea(Request $request)
  {

    if (auth()->user()->can('edit-wiki')) {
      $changeImage = $request->idea_change_image;
      $idea_id = $request->idea_id;
      $idea_cloud_url = $request->idea_cloud_url;
      $idea_title = $request->idea_title;
      $idea_category = $request->idea_category;
      $idea_minimal_fund = $request->idea_minimal_fund;
      $idea_risk = $request->idea_risk;
      $idea_profitability = $request->idea_profitability;
      $idea_profitability_memo = $request->idea_profitability_memo;
      $idea_manpower = $request->idea_manpower;
      $idea_scale = $request->idea_scale;
      $idea_state = $request->idea_state;
      $idea_abstractMemo = $request->idea_abstractMemo;
      $idea_memo = $request->idea_memo;

      $idea = wikiidea::where("id", "=", $idea_id)->first();

      if ($idea != null) {
        $imgFileName = '';
        $videoFileName = '';
        if ($changeImage == 1)
          if ($request->file('idea_image')) {
            $folderPath = "_upload_/_wikiideas_/" . $idea->code;
            delete_directory($folderPath);
            $imgFileName = uploadImageFileWithWatermark($request->file('idea_image'), $folderPath);
            $idea->image = $imgFileName;
          }

        $idea->cloud_url = $idea_cloud_url;
        $idea->title = $idea_title;
        $idea->id_category = $idea_category;
        $idea->minimal_fund = $idea_minimal_fund;
        $idea->risk = $idea_risk;
        $idea->profitability = $idea_profitability;
        $idea->profitability_memo = $idea_profitability_memo;
        $idea->manpower = $idea_manpower;
        $idea->scale = $idea_scale;
        $idea->memo = $idea_memo;
        $idea->abstractMemo = $idea_abstractMemo;
        $idea->publisher_name = "کسب بوم";
        $idea->state = $idea_state;
        $idea->memo = $idea_memo;
        $idea->save();

        return ($this->ajax_response(false,'','ثبت تغییرات ایده با موفقیت انجام شد','success'));

      }
    }
    else{
      return response()->json($this->accessdenide_response);
    }


  }

  public function view_idea($id,$title)
  {
    if (auth()->user()->can('viewItem-wiki')){

      $idea = wikiidea::where("id", "=", $id)->first();
      $cats = getCategory('idea');
      $states = getState();
      if ($idea != '' && $idea != null)
        return view("_manager.wiki.detail_idea", compact("idea", "cats", "states"));
      else {
        $message = "ایده مورد نظر یافت نشد";
        $backUrl = '_manager/wikiideas';
        return view("_manager.message", compact("message", "backUrl"));
      }
    }
    else
      return view("_manager/accessdenid");

  }

  public function wiki_comments(Request $request)
  {

    if (auth()->user()->can('comment-wiki')){

      $id_idea=$request->id_idea;

      $data=Datatables::of(comment::where("type","=","idea")
        ->where("id_target","=",$id_idea))
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })->make(true);

      return $data;
    }
    else
      return "";
  }

  public function wiki_all_comments()
  {
    if (auth()->user()->can('comment-wiki')){

      $comments = comment::where("type", "=", "idea");
      $sum_score=$comments->sum("score");

      $comment_count=$comments->count();

      $up_count=$comments->where("score","=",5)->count();

      $down_count=$comments->where("score","=",1)->count();

      $mean_count=0;
      if($comment_count>0)
        $mean_count=($sum_score / $comment_count);


      return view("_manager.wiki.comments", compact("comment_count", "up_count", "down_count", "mean_count"));
    }
    else
      return view("_manager/accessdenid");
  }

  public function all_wiki_comments()
  {
    if (auth()->user()->can('comment-wiki')){
      return Datatables::of(comment::where("type","=","idea"))
        ->addColumn('fullname', function ($row) {
          return $row->getUserName();
        })
        ->addColumn('title', function ($row) {
          return $row->getWikiName();
        })->make(true);
    }
    else
      return "";
  }
}
