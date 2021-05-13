<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Doctor;
use App\Models\Card;
use App\Models\User;
class DoctorListController extends Controller
{
  public function index()
  {
    $doc_id=NULL;
      /*$arrnum=NULL;*/
    $_SESSION['select_month']=0;
    //return view('pages.DoctorList');
    $doctors = Doctor::all();
    //dd($doctors[0]->users[0]->pivot->Times);
      //$numofrows=$doctors[$doc_id-1]->users->count();

    $data=array('doc_id'=>$doc_id,'doctors'=>$doctors/*,'arrnum'=>$arrnum*/);
    return View::make('pages.DoctorList')->with($data);
  }
  public function store(Request $request)
  {
      if (isset($_POST['previous']))
      {$doc_id=$request->previous;
          /*$arrnum=$request->arrnum;*/
          $doctors = Doctor::all();
          //$numofrows=$doctors[$doc_id-1]->users->count();
        $data=array('doc_id'=>$doc_id,'doctors'=>$doctors/*,'arrnum'=>$arrnum*/);
        $_SESSION['select_month']=(-1);
        return View::make('pages.DoctorList')->with($data);
      }
      if (isset($_POST['next']))
      {$doc_id=$request->next;
          /*$arrnum=$request->arrnum;*/
          $doctors = Doctor::all();
          //$numofrows=$doctors[$doc_id-1]->users->count();
        $data=array('doc_id'=>$doc_id,'doctors'=>$doctors/*,'arrnum'=>$arrnum*/);
        $_SESSION['select_month']=1;
        return View::make('pages.DoctorList')->with($data);
      }
      if (isset($_POST['current']))
      {$doc_id=$request->current;
          /*$arrnum=$request->arrnum;*/
          $doctors = Doctor::all();
          //$numofrows=$doctors[$doc_id-1]->users->count();
        $data=array('doc_id'=>$doc_id,'doctors'=>$doctors/*,'arrnum'=>$arrnum*/);
        $_SESSION['select_month']=0;
        return View::make('pages.DoctorList')->with($data);
      }
    $_SESSION['select_month']=0;
    //dd($request->drone);
    $doc_id=$request->drone;
    /*$arrnum=$request->arrnum;*/
    //$compactData=array('doc_id');

      $doctors = Doctor::all();
      //$numofrows=$doctors[$doc_id-1]->users->count();
      $data=array('doc_id'=>$doc_id,'doctors'=>$doctors/*,'arrnum'=>$arrnum*/);
    //return redirect()->route('pages.DoctorList');
    //return View::make('pages.DoctorList', compact($compactData));
    return View::make('pages.DoctorList')->with($data);
  }
}
