<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Doctor;
use App\Models\DoctorUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

class DashboardController extends Controller
{
    public function index()
    {
      //dd(auth()->user());
        //$doc_use= DoctorUser::orderBy('date_register', 'asc')->get();
        $doctors = Doctor::with(['users' => function ($q) {
            $q->orderBy('date_register', 'asc');
        }])->get();
        //dd($doc_use[0]->date_register);
        return view('dashboard',['doctors'=>$doctors/*,'doc_use'=>$doc_use*/]);
    }
    public function index2()
    {
        $doctors = Doctor::with(['users' => function ($q) {
            $q->orderBy('date_register', 'asc');
        }])->get();
        //dd(auth ('doctor')->user()->cards);
        return view('doctordashboard',['doctors'=>$doctors/*,'doc_use'=>$doc_use*/]);
    }
    public function edit($id)
    {
        $user=User::find($id);
        //dd($user->name);
        return view('pages.edit.user',['user'=>$user,'id'=>$id]);
    }
    public function update(Request $request,$id)
    {
        //dd($request->get('avatar')!=NULL);
        if($request->hasFile('avatar')){
            $this->validate($request,['avatar'=>'file|mimes:jpeg,bmp,png|max:2000']);
            //dd($request->file('avatar')->getSize());
            $avatar =$request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('/uploads/avatars/'.$filename) );
            $user=User::find($id);
            $user->avatar=$filename;
            $user->save();
        }
        $this->validate($request,[
            'username'=>'required|max:255',
            'email'=>'required|email|max:255',
            'name'=>'required|max:255',
            'surname'=>'required|max:255',
            'password'=>'required'
        ]);
        $user=User::find($id);
        $user->username=$request->get('username');
        $user->email=$request->get('email');
        $user->name=$request->get('name');
        $user->surname=$request->get('surname');
        $user->password=Hash::make($request->get('password'));
        $user->save();
        return redirect()->route('dashboard')->with('success','Your account was updated');
    }
    public function destroy(Request $User)
    {
        //dd($User->drone);
        $id=$User->drone;
        Card::where('user_id', $id)->delete();
        DoctorUser::where('user_id', $id)->delete();
        User::destroy($id);
        auth()->logout();
        return View::make('home');
    }

}
