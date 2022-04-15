<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Jobpost;
use App\Models\Jobrequest;
use App\Models\Employee;
use App\Models\Rating;
use App\Models\Favorite;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Validator;
use Mail;
use DB;
use File;
use Illuminate\Database\Eloquent\Builder;
class JobpostController extends Controller
{
    public $successStatus = 200;
    private $apiToken;
    public function __construct()
    {
      $this->apiToken = uniqid(base64_encode(Str::random(10)));
    }
    public function one_validation_message($validator)
    {
       $validation_messages = $validator->getMessageBag()->toArray();
       $validation_messages1 = array_values($validation_messages);             
          $new_validation_messages = [];
          for ($i = 0; $i < count($validation_messages1); $i++) 
          { 
              $inside_element = count($validation_messages1[$i]);
               for ($j=0; $j < $inside_element; $j++)
               { 
                 array_push($new_validation_messages,$validation_messages1[$i]);
               }
          }
       return implode(' ',$new_validation_messages[0]);     
    }
     public function AddDeleteFavorite(Request $request) 
    {
      try {  
             $validator = Validator::make($request->all(), 
                  [   
                    'user_id'=>'required',
                    'emp_id' => 'unique:users',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }     
          $Favorite = Favorite::where('user_id',$request->user_id)->where('post_id',$request->post_id)->first();
          if($Favorite)
          {
            $Favorite->delete();
            return response()->json(['status' => 'success' , 'message' => "Deleted.", 'code' => '200'],200);  
          }
          else
          {
            $Favorite = new Favorite();
            $Favorite->user_id = $request->user_id;
          $Favorite->post_id = $request->post_id;
          $Favorite->save();
          return response()->json(['status' => 'success' , 'message' => "Added.", 'code' => '200'],200); 
          }
            
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function AddPost(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             $validator = Validator::make($request->all(), 
                  [   
                    'job_title'=>'required',
                    'job_subtitle' =>'required',
                    'employee_type' => 'required',
                    'job_description' => 'required',
                    'salary' => 'required',
                    'highlight_points' => 'required',
                    'date' => 'required|date',
                    'start_time' => 'required',
                    'end_time' => 'required',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }             
          $user = new Jobpost();
          $user->job_title = ($request->job_title == '' ? '': $request->job_title);   
          $user->job_subtitle = $request->job_subtitle;  
          $user->emp_id = $request->emp_id;  
          $user->employee_type = $request->employee_type;  
          $user->location = $request->location;
          $user->job_description  = $request->job_description;
          $user->salary  = $request->salary;
          $user->highlight_points  = $request->highlight_points;
          $user->date  = $request->date;
          $user->start_time  = $request->start_time;
          $user->end_time = $request->end_time;
          $user->save(); 
          return response()->json(['status' => 'success' , 'message' => "Added", 'code' => '200', 'data' => $user],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }  
  public function ListPost(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
           
          $expdetils = Jobpost::withCount(['countsrequest' => function ($query) {
                        $query->where('status', '=', 0);
                    }])->with('employeedtails')->with(['userdetails' => function ($query) {
                            $query->select('id', 'name');
                    }])->where('emp_id',$request->emp_id)->where('status',$request->status)->orderBy('id', 'desc')->get();
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $expdetils],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function UserListPost(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             
          $expdetils = Jobpost::withCount(['countsrequest' => function ($query)  {
                        $query->where('status', '=', 0);
                    }])->with('employeedtails')->where('emp_id',$request->emp_id)->where('id',$request->postid)->orderBy('id', 'desc')->first();
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $expdetils],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function DeletePost(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             
          $expdetils = Jobpost::where('id',$request->id)->delete();

          if($expdetils)
          {
            
            return response()->json(['status' => 'success' , 'message' => "Deleted", 'code' => '200'],200); 
          }
           else 
           {
                return response()->json(['status' => 'success' , 'message' => "Not found", 'code' => '200'],200); 
            } 
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function EditPost(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             $validator = Validator::make($request->all(), 
                  [   
                    'job_title'=>'required',
                    'job_subtitle' =>'required',
                    'employee_type' => 'required',
                    'job_description' => 'required',
                    'salary' => 'required',
                    'highlight_points' => 'required',
                    'date' => 'required|date',
                    'start_time' => 'required',
                    'end_time' => 'required',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }               
          $user = Jobpost::where('id',$request->id)->first();
          $user->job_title = ($request->job_title == '' ? $user->job_title : $request->job_title);   
          $user->job_subtitle = ($request->job_subtitle == '' ? $user->job_subtitle : $request->job_subtitle);  
          $user->emp_id = ($request->emp_id == '' ? $user->emp_id : $request->emp_id);  
          $user->employee_type = ($request->employee_type == '' ? $user->employee_type : $request->employee_type);
          $user->location  = ($request->location == '' ? $user->location : $request->location);
          $user->job_description  = ($request->job_description == '' ? $user->job_description : $request->job_description);
          $user->salary  = ($request->salary == '' ? $user->salary : $request->salary);
          $user->highlight_points  = ($request->highlight_points == '' ? $user->highlight_points : $request->highlight_points);
          $user->date  = ($request->date == '' ? $user->date : $request->date);
          $user->start_time  = ($request->start_time == '' ? $user->start_time : $request->start_time);
          $user->end_time  = ($request->end_time == '' ? $user->end_time : $request->end_time);
          $user->save();
          return response()->json(['status' => 'success' , 'message' => "Updated.", 'code' => '200', 'data' => $user],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
   public function sendRequest(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             $validator = Validator::make($request->all(), 
                  [   
                    'post_id'=>'required',
                    'candidate_id' =>'required',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }     
          $check = Jobrequest::where('post_id',$request->post_id)->where('candidate_id',$request->candidate_id)->where('status','0')->first();
          if($check)
          {
              return response()->json(['status' => 'fail' , 'message' => 'You already applied for this job, waiting for a reply.', 'data' => json_decode('{}'), 'code' => '401'],200);
          }
          $user = new Jobrequest();
          $user->post_id = ($request->post_id == '' ? '': $request->post_id);   
          $user->candidate_id = $request->candidate_id;  
          $user->message = $request->message; 
          $user->save(); 
          return response()->json(['status' => 'success' , 'message' => "Added", 'code' => '200', 'data' => $user],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }  
     public function requestList(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             
          $expdetils = Jobrequest::with('userdetails')->where('post_id',$request->post_id)->where('status','0')->orderBy('id', 'desc')->get();
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $expdetils],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function AcceptFinishPostlist(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             
          $expdetils = Jobrequest::with('userdetails')->where('post_id',$request->post_id)->where('status',$request->status)->orderBy('id', 'desc')->get();
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $expdetils],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }

    }

    public function AcceptRejectPostRequest(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             $validator = Validator::make($request->all(), 
                  [   
                    'post_id'=>'required',
                    'status' =>'required',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }               
          $user = Jobrequest::where('id',$request->request_id)->first();
          $user->status = $request->status;
          $user->save();
          if($request->status == 1) 
          { 
            $candidate_id = $user->candidate_id; 
          } 
          else 
          { 
          $candidate_id = 0; 
          }
          
          if($request->status == 1)
          {
         $post = Jobpost::where('id',$request->post_id)->first();
          $post->status = '2';
          $post->userid = $candidate_id;
          $post->save();
            Jobrequest::where('post_id',$request->post_id)->where('status','0')->delete();
          }
         
          if($request->status == '1') { $message = 'Accepted'; }else{ $message = 'Rejected';}
          return response()->json(['status' => 'success' , 'message' => $message, 'code' => '200', 'data' => $user],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function CompaltePost(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             $validator = Validator::make($request->all(), 
                  [   
                    'post_id'=>'required',
                    'status' =>'required',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }               
          $user = Jobpost::where('id',$request->post_id)->first();
          $user->status = $request->status;
          $user->save();
          return response()->json(['status' => 'success' , 'message' => "Updated.", 'code' => '200', 'data' => $user],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function listPostForApply(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
          $expdetils = Jobpost::withCount(['countsrequest'])->with('employeedtails')->where('status','1')->orderBy('id', 'desc')->get();
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $expdetils],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function getFavoritelist(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
        $expids =  array();
             $useridfav =  Favorite::where('user_id',$user)->get();
            foreach ($useridfav as $key => $value) {
              $expids[] = $value['post_id'];
            }
          $expdetils = Jobpost::withcount(['flag' => function ($query) use ($user) {
                        $query->where('user_id', $user);
                    }])->withCount(['countsrequest'])->with('employeedtails')->where('status','1')->orderBy('id', 'desc')->whereIn('id',$expids)->get();
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $expdetils],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function SearchAndFilterPost(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
          $key = $request->searchkey;
          $category = $request->category;
          $salarystart = $request->salarystart;
          $salaryend = $request->salaryend;
          $from = date($request->startdate);
          $to = date($request->enddate);
          $employee_type = $request->employee_type;
          $location = $request->location;
          $expdetils = Jobpost::withcount(['flag' => function ($query) use ($user) {
                        $query->where('user_id', $user);
                    }])->withCount(['countsrequest'])->with('employeedtails');
          if($key != '')
          {
           
            $expdetils->where('job_title','LIKE','%'.$key.'%');
          }
          if(($from != '') && ($to  != ''))
         {
          
          $expdetils->whereBetween('date',[$from,$to]);
         }
        if(($salarystart != '') && ($salaryend != ''))   
        {

         $expdetils->whereBetween('salary', [$salarystart, $salaryend]);
        }
         if($employee_type != '')
          {
           
            $expdetils->where('employee_type','LIKE','%'.$employee_type.'%');
          }
          if($location != '')
          {
           
            $expdetils->where('location','LIKE','%'.$location.'%');
          }
         if($category != '') 
          {
            $emp = Employee::where('domain_category', 'Like', '%'.$category.'%')->get();
            $ids = array();
            foreach ($emp as $key => $value) 
            {
                $ids[] = $value['id'];
            }
                $expdetils->whereIn('emp_id',$ids);
          }
          $query = $expdetils->where('status','1')->orderBy('id', 'desc')->get();
          // print_r($query);die;
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $query],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function SearchAndFilterPostemployee(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
            $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
          $key = $request->searchkey;
          $category = $request->category;
          $salarystart = $request->salarystart;
          $salaryend = $request->salaryend;
          $from = date($request->startdate);
          $to = date($request->enddate);
          $employee_type = $request->employee_type;
          $location = $request->location;
          $expdetils = Jobpost::withCount(['countsrequest' => function ($query) {
                        $query->where('status', '=', 0);
                    }])->with('employeedtails');
          if($key != '')
          {
           
            $expdetils->where('job_title','LIKE','%'.$key.'%');
          }
               if(($from != '') && ($to  != ''))

         {
          
          $expdetils->whereBetween('date',[$from,$to]);
         }
         if(($salarystart != '') && ($salaryend != ''))   
        {

         $expdetils->whereBetween('salary', [$salarystart, $salaryend]);
        }
         if($employee_type  != '')
          {
           
            $expdetils->where('employee_type','LIKE','%'.$employee_type.'%');
          }
          if($location  != '')
          {
           
            $expdetils->where('location','LIKE','%'.$location.'%');
          }
         if($category != '')
          {
            $emp = Employee::where('domain_category', 'Like', '%'.$category.'%')->get();
            $ids = array();
            foreach ($emp as $key => $value) 
            {
                $ids[] = $value['id'];
            }
                $expdetils->whereIn('emp_id',$ids);
          }
          $query = $expdetils->orderBy('id', 'desc')->where('emp_id',$user)->get();
          // print_r($query);die;
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $query],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function AddRating(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             $validator = Validator::make($request->all(), 
                  [   
                    'userid'=>'required',
                    'emp_id' =>'required',
                    'rate' => 'required',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }             
          $user = new Rating();
          $user->user_id = $request->userid;  
          $user->emp_id = $request->emp_id;  
          $user->rate = $request->rate;
          $user->save();
          $rateavg = Rating::where('emp_id',$request->emp_id)->avg('rate'); 
          $avgrating = Employee::where('id',$request->emp_id)->first();
          $avgrating->rating = round($rateavg);
          $avgrating->save();
          return response()->json(['status' => 'success' , 'message' => "rating Added", 'code' => '200', 'data' => $user],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    } 
    public function JobDetails(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
        ;
        if($request->status == '3')
            {
             // echo "1";
                      $Jobrequest = Jobrequest::where('candidate_id',$user)->get();
            }
            else
            {
         //echo "2";
                        $Jobrequest = Jobrequest::where('candidate_id',$user)->where('status',$request->status)->get();

            }
           // print_r($Jobrequest->toArray());die;
            $ids = array();
            foreach ($Jobrequest as $key => $value) 
            {
                $ids[] = $value['post_id'];
            }
           // print_r($ids);die;

        $expdetils = Jobpost::withCount(['countsrequest'])->with('employeedtails')->orderBy('id', 'desc')->whereIn('id',$ids);
        if($request->status == 3)
        {
            $expdetils->where('status','0');
        }   
        if($request->status == 0)
        {
            $expdetils->where('status','1');
        } 
        if($request->status == 1)
        {
            $expdetils->where('status','2');
        } 
      if($request->status == 2)
        {
           // echo "dd";
            $expdetils->where('status','1');
        } 
       $query = $expdetils->get();
          return response()->json(['status' => 'success' , 'message' => "suceess", 'code' => '200', 'data' => $query],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
}
