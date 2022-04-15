<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;

class HomeController extends Controller

{

	public function __construct()    

	{       

	 $this->middleware('auth:admin');   

	} 

	public function index()    

	{             

		$user = '11';//User::count();        

		return view('admin.dashboard',compact('user'));    

	}

}