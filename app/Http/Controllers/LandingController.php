<?php

namespace App\Http\Controllers;


use App\Models\Roadmap;
use App\Models\RoadmapContent;

class LandingController extends Controller
{
  public function nashenavayan()
  {
    return view('landingpages.nashenavayan.index');
  }
  public function suppliers()
  {
    return view('landingpages.suppliers.index');
  }
  public function supplier_panuch()
  {
    return view('landingpages.suppliers.panuch');
  }
  public function roadmap()
  {
    $roadmaps=Roadmap::where('status',1)->select('id','slug','code','avatar','title')->get();
    return view('landingpages.roadmap.index',compact('roadmaps'));
  }

  public function roadmapContent($slug)
  {
    $roadmap=Roadmap::where('slug','=',$slug)->get()->first();
    $contents=RoadmapContent::where('roadmap_id',$roadmap->id)->get()->sortBy('number');
    return view('landingpages.roadmap.content',compact('roadmap', 'contents'));
  }
  public function roadmap_charm()
  {
    return view('landingpages.roadmap.charm');
  }
  public function roadmap_namad()
  {
    return view('landingpages.roadmap.namad');
  }
}
