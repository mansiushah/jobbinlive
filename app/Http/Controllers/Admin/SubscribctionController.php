<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
class SubscribctionController extends Controller
{
   public function index()
    {
        $data = Subscription::all();
        return view('admin.subscription.index', compact('data'));
    }
    public function create()
    {
        return view('admin.subscription.create');
    }
public function store(Request $request)
{
    $request->validate([
            'title'    =>  'required',
        ]);
        $form_data = array(
            'title'       =>   $request->title,
        );
    Subscription::create($form_data);
    return redirect()->route('subscription.index')->with('success', 'Data Added successfully.');
}
    public function edit($id)
    {
    $data = Subscription::findOrFail($id);
    return view('admin.subscription.edit', compact('data'));
    }
public function update(Request $request)
{
        
           $request->validate([
             'title'    =>  'required',
            ]);
        
       $form_data = array(
            'title'       =>   $request->title
        );
        Subscription::whereId($request->id)->update($form_data);
        return redirect()->route('admin.subscription.index')->with('success', 'Data is successfully updated');
    }
    public function destroy($id)
    {
        $data = Subscription::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.subscription.index')->with('success', 'Data is successfully deleted');
    }
}



