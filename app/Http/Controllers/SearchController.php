<?php

namespace App\Http\Controllers;

use App\Models\consult;
use App\Models\course;
use App\Models\webinar;
use App\Models\wikiidea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

  public function search () {
    $search = request()->search_title;

//    course
    $courses = course::where('status', 1)
      ->where(function ($q) use ($search) {
        $q->where('title', 'like', "%$search%")
          ->orwhere('abstractMemo', 'like', "%$search%");
      })
      ->with([
        'category' => function ($query) {
          $query->select('id', 'title');
        },
        'teacher' => function ($query) {
          $query->select('id', 'fullname');
        }
      ])->select('id', 'title', 'slug', 'image', 'price', 'hour', 'minutes', 'id_category', 'id_teacher', 'register_count', 'code', 'learn_type', 'discount', 'abstractMemo', 'score', 'discount', 'old_price', 'view_count', 'like_count', 'comment_count')
      ->limit(8)->get();

//    consult
    $consults = consult::where('status', 1)
      ->with(['category' => function ($query) {
        $query->select('id', 'title');
      }])->select('id', 'fullname', 'id_category', 'image', 'consult_field', 'code', 'abstractAbout', 'score', 'view_count', 'consult_count', 'comment_count', 'consult_price_present', 'consult_price_tel', 'consult_price_live')
      ->where(function ($q) use ($search) {
        $q->where('fullname', 'LIKE', "%$search%");
      })->limit(8)->get();

//    idea
    $ideas = wikiidea::where('status', 1)
      ->select('id', 'id_user', 'title', 'image', 'code', 'minimal_fund', 'risk', 'profitability', 'id_category', 'abstractMemo', 'score', 'like_count', 'view_count', 'comment_count')
      ->where(function ($q) use ($search) {
        $q->where('title', 'LIKE', "%$search%")
          ->orWhere('memo', 'LIKE', "%$search%")
          ->orWhere('abstractMemo', 'LIKE', "%$search%");
      })
      ->with(['writer' => function($q) {
        $q->select('id', 'name', 'code', 'image');
      }])->limit(8)->latest('id')->get();

//    webinar
    $webinars = webinar::where([['status', '>', 0], ['title', 'LIKE', "%$search%"]])
      ->with(['category' => function ($query) {
        $query->select('id', 'title');
      }])
      ->limit(8)
      ->latest('webinar_date')->get();

    return view('searchResult', compact('courses', 'webinars', 'consults', 'ideas'));
  }


}
