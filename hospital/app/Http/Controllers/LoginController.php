<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Intervention\Image\Facades\Image;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        //dd($user->getAvatar());
        $authUser =$this->findOrCreateUser($user,$provider);
        Auth::login($authUser,true);
        return redirect()->route('dashboard');
    }

    public function findOrCreateUser($user,$provider)
    {
        $authUser=User::where('provider_id',$user->id)->first();
        //dd($authUser);
        if($authUser){
            return $authUser;
        }
        return User::create([
            'username'=>$user->name,
            'email'=>$user->email,
            'name'=>$user->user['given_name'],
            'surname'=>$user->user['family_name'],
            'password'=>Hash::make($user->name),
            'provider'=>strtoupper($provider),
            'provider_id'=>$user->id
        ]);
    }

  public function index()
  {

      //creates an admin role and permission if there are no roles yet
      //if(!DB::table('roles')->count()>0)
      //{Role::create(['name'=>'admin']);
      //    Permission::create(['name'=>'create doctor']);
      //    $role =Role::findById(1);
      //    $permission=Permission::findById(1);
      //    $role->givePermissionTo($permission);
      //}
      return view('auth.login');
  }
  public function store(Request $request)
  {
      auth()->logout();
      auth('doctor')->logout();
      $this->validate($request,
        [
          'username'=>'required',
          'password'=>'required',
        ]
      );
      //tikrina ar bando prisijungti daktaras
      //$username=$request->input('username');
      //$password=md5($request->input('password'));
      //dd($password);
      //$query = "SELECT * FROM doctors WHERE username='$username' AND password='$password'";
      //$results = mysqli_query(mysqli_connect("localhost","root","","hospital","3306"), $query);
      //if (mysqli_num_rows($results) == 1)
      //dd($request->password);  ['username'=>$username,'password'=>$password]
      if(auth('doctor')->attempt($request->only('username','password')))
      {
        return redirect()->route('doctordashboard');
      }
      //atmesti vartotoja jeigu username ir password kombinacijos nera
      elseif (!auth()->attempt($request->only('username','password')))
      {
        return back()->with('status','Invalid login deatails');
      }
      //dd(auth()->user()->getPermissionsViaRoles());

      return redirect()->route('dashboard');
  }
}
