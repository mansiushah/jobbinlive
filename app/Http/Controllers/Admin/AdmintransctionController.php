<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OrderSubscriptions;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use App\Withdrawrequest;

class AdmintransctionController extends Controller
{
    //
     public function index(Request $request)
    {
    	 if(!Auth::check())
        {
            return Redirect::to("login")->withSuccess('Opps! You do not have access');
        }
        $driverid = $request->driver_id;
        $data = Withdrawrequest::all();
        $total = OrderSubscriptions::sum('amount');
        $withdraw = Withdrawrequest::where('status','Paid')->sum('admin_amount');
        $sum = $total - $withdraw;
        return view('admin.transaction.index', compact('data','sum'));
	}
          public function bankdetails(Request $request) {

            $id = $request->id;
    $design = Bank::where('id',$id)->first();  

    return Response::json($design);
}
     public function edit($id)
    {
        //
       // echo $id;die;
        if(!Auth::check())
        {
            return Redirect::to("login")->withSuccess('Opps! You do not have access');
        }
         $data = Withdrawrequest::findOrFail($id);
        return view('admin.transaction.edit', compact('data'));
    }
    public function update(Request $request)
    {
        //
        if(!Auth::check())
        {
            return Redirect::to("login")->withSuccess('Opps! You do not have access');
        }
       
            $request->validate([
             'status'    =>  'required',
             'admin_amount' =>'required'
            ]);
           $form_data = array(
            'status'  =>   $request->status,
            'admin_amount' =>$request->admin_amount
        );
  
        Withdrawrequest::whereId($request->id)->update($form_data);

        return redirect()->route('admin.transaction.index')->with('success', 'Data is successfully updated');
    }


}
