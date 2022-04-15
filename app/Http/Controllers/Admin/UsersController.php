<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator,Redirect,Response;

class UsersController extends Controller
{
   public function UserList()
    {
        $data = User::get();
      return view('admin.user', compact('data'));
    }
    public function Userview($id)
    {
        $user = User::where('id',$id)->first();
      return view('admin.userview', compact('user'));
    }
    public function ChangeStatus($id, Request $request)
    {
          $data =  User::findOrFail($id);
          if($request->isMethod('POST')){
            $request->validate([
                'status' => 'required'
            ]);
            $status = User::findOrFail($id);
            $status->status       =   $request->status;
            $status->save();
                return redirect()->route('admin.restaurant')->with('alert-success','Cusomer has been updated successfully');
    }
        return view('admin.updateStatus',compact('data'));
    }
}







