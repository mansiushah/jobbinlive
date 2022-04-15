<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Admin;

use App\Models\Role;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;



class AdminController extends Controller

{    

    public function __construct()

    {

       $this->middleware('auth:admin');

 	//$this->middleware('guest:admin');

    }

    public function dashboard()

    {

        $user = User::count();  
        return view('admin.dashboard')->with('user',$user);

    }  

    public function manageProfile(){

        $data=array();

        $users=User::with('role')->get();

        $role=Role::get();

        $data['users']=$users;

        $data['role']=$role;

        return view('admin.manage_profile.userlist',$data);

    }   

    public function editUser($id){

        $data=array();

        $role=Role::get();

        $data['role']=$role;

        $users=User::with('role')->find($id);

        $data['users']=$users;

        return view('admin.manage_profile.edituser',$data);

    }

    public function updateUserProfile(Request $request){

        $users=User::find($request->user_id);

        $users->username=$request->username;

        $users->email=$request->email;

        $users->rolle_id=$request->role;

        $users->save();

        return redirect()->back()->with('success','Successfully profile update...'); 

            

    }

    public function createUser(Request $request){

        

        $messages = [

            'required' => 'This field is required',          

            'confirmed'    => 'Confirm password does not match',                 

        ];

        

        $validator = $this->validate($request, [

            'username' => 'required|string|max:255',

            'email' => 'required|email|unique:users',

            'password' => 'required|confirmed',

        ],$messages);

        

        

        $api_token=Str::random(20);

        

        User::create([

            'username' => $request->username,

            'rolle_id' => $request->role,

            'email' => $request->email,

            'api_token' => $api_token,

            'phone_no' => ' ',

            'password' => sha1($request->password),

        ]);

       

        return redirect()->back()->with('success','Successfully created...'); 



    }   

    

    public function updateAdminProfile(Request $request){



        $admin=Admin::find($request->admin_id);



        $admin->name=$request->name;

        $admin->email=$request->email;        

        if(isset($request->password) && !empty($request->password)){

            $admin->password=Hash::make($request->password);

        }

        

        $admin->save();

        

        return redirect()->back()->with('success','Successfully profile update...'); 

            

    }

    public function manageAdmin(){

        $data=array();

        $users=Admin::get();

        $data['adminlist']=$users;       

        return view('admin.manage_profile.adminlist',$data);

    }

    public function editAdmin($id){

        $data=array();

        $users=Admin::find($id);

        $data['admin']=$users;

        

        return view('admin.manage_profile.editadmin',$data);

    }

    public function addNewAdmin(){

        $data=array();

        return view('admin.manage_profile.add-new-admin',$data);

    }

    protected function createAdmin(Request $request)

    {

        $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|string|email|max:255|unique:admins',

            'password' => 'required|string|min:6',

        ]);

        Admin::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

        ]);

        return redirect()->back()->with('success','Successfully created...'); 

    }

    public function addNewUser(){        

        $data=array();

        $role=Role::get();

        $data['role']=$role;

        return view('admin.manage_profile.add-new-user',$data);

    }

    

    public function trainerApplication(){

        $data=array();

        return view('admin.trainer.trainer_list',$data);

    }

    

}

