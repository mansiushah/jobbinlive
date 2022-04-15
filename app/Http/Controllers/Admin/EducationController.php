<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\Eduction;
use Illuminate\Support\Facades\Auth;
class EducationController extends Controller
{
   public function index()
    {
        $data = Eduction::all();
        return view('admin.education.index', compact('data'));
    }
    public function create()
    {
        return view('admin.education.create');
    }
    public function store(Request $request)
    {
    $request->validate([
            'title'    =>  'required',
    ]);
        $form_data = array(
            'title'       =>   $request->title
        );
    Eduction::create($form_data);
    return redirect('/admin/education')->with('success', 'Data Added successfully.');
    }
    public function edit($id)
    {
    $data = Eduction::findOrFail($id);
    return view('admin.education.edit', compact('data'));
    }
    public function show($id)
    {
        $data = Eduction::findOrFail($id);
       
    }
    public function update(Request $request)
    {
        $request->validate([
             'title'    =>  'required',
            ]);
       $form_data = array(
            'title'       =>   $request->title,
        );
        Eduction::whereId($request->id)->update($form_data);
        return redirect('/admin/education')->with('success', 'Data is successfully updated');
    }
    public function destroy($id)
    {
        $data = Eduction::findOrFail($id);
        $data->delete();
        return redirect('/admin/education')->with('success', 'Data is successfully deleted');
    }
}

