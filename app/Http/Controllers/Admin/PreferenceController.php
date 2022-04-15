<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;
class PreferenceController extends Controller
{
   public function index()
    {

        $data = Preference::all();
        return view('admin.preference.index', compact('data'));
    }
    public function create()
    {
        return view('admin.preference.create');
    }
    public function store(Request $request)
    {
    $request->validate([
            'title'    =>  'required'
        ]);
        $form_data = array(
            'title'       =>   $request->title           
        );
    Preference::create($form_data);
    return redirect('/admin/preference')->with('success', 'Data Added successfully.');
    }
    public function show($id)
    {
        $data = Preference::findOrFail($id);
        return view('admin.preference.view', compact('data'));
    }
    public function edit($id)
    {
    $data = Preference::findOrFail($id);
    return view('admin.preference.edit', compact('data'));
    }
    public function update(Request $request)
    {
        $request->validate([
             'title'    =>  'required',
            ]);
       $form_data = array(
            'title'       =>   $request->title,
            );
        Preference::whereId($request->id)->update($form_data);
        return redirect('/admin/preference')->with('success', 'Data is successfully updated');
    }
    public function destroy($id)
    {
        $data = Preference::findOrFail($id);
        $data->delete();
         return redirect('/admin/preference')->with('success', 'Data is successfully deleted');
    }
}



