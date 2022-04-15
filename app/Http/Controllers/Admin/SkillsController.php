<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\Skills;
use Illuminate\Support\Facades\Auth;
class SkillsController extends Controller
{
   public function index()
    {
        $data = Skills::all();
        return view('admin.skills.index', compact('data'));
    }
    public function create()
    {
        return view('admin.skills.create');
    }
public function store(Request $request)
{
    $request->validate([
            'title'    =>  'required',
        ]);
        $form_data = array(
            'title'       =>   $request->title,
        );
    Skills::create($form_data);
    return redirect('/admin/skills')->with('success', 'Data Added successfully.');
}
    public function edit($id)
    {
    $data = Skills::findOrFail($id);
    return view('admin.skills.edit', compact('data'));
    }
public function update(Request $request)
{
        
           $request->validate([
             'title'    =>  'required',
            ]);
        
       $form_data = array(
            'title'       =>   $request->title
        );
        Skills::whereId($request->id)->update($form_data);
        return redirect('/admin/skills')->with('success', 'Data is successfully updated');
    }
    public function destroy($id)
    {
        $data = Skills::findOrFail($id);
        $data->delete();
        return redirect('/admin/skills')->with('success', 'Data is successfully deleted');
    }
}



