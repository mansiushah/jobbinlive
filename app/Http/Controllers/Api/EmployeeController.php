<?php

namespace App\Http\Controllers\Api;
use App\Models\Employee;
use App\Models\Bankdetails;
use App\Models\Jobpost;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Validator;
use Mail;
use DB;
class EmployeeController extends Controller
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
    public function login(Request $request)
    {
        try {
          $rules = [
              'username'=>'required',
              'password'=>'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) 
            {
              $message = $this->one_validation_message($validator);
                return response()->json(['status' => 'error' , 'message' => $message, 'code' => '400', 'data' => json_decode('{}')],200);
            }
            else
            {
                  $user = Employee::where('email',$request->username)->orwhere('name',$request->username)->first();
                  if($user) 
                  {
                      if(password_verify($request->password, $user->password)) 
                      {
                        $postArray = ['custom_token' => $this->apiToken,'fcm_token'=>($request->fcm_token == '' ?'':$request->fcm_token),'device_type'=>$request->device_type];
                        $login = Employee::where('email',$request->username)->orwhere('name',$request->username)->update($postArray);          
                        if($login && $user->status == '1') 
                        {
                          $user1 = Employee::where('email',$request->username)->orwhere('name',$request->username)->first();
                          return response()->json(['status' => 'success' , 'message' => "User successfully login", 'code' => '200', 'data' => $user1],200);
                        }
                       
                        else
                        {
                          return response()->json(['status' => 'error' ,'message' => 'Block by admin', 'code' => '401', 'data' => json_decode('{}')],200);
                        }
                       } 
                      else 
                      {
                        return response()->json(['status' => 'error' ,'message' => 'Invalid Password', 'code' => '401', 'data' => json_decode('{}')],200);
                      }

                  } 
                  else 
                  {
                      return response()->json(['status' => 'error' ,'message' => 'User not found', 'data' => json_decode('{}'),'code' => '401'],200);
                  }

            }

        } catch (\Exception $e) {

              return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);

        }

       }
    public function register(Request $request) 
    {
      try {  
             $validator = Validator::make($request->all(), 
                  [   
  
                    'email' => 'required|unique:users|unique:employee',
                    'password' => 'required',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }     
          $code = rand ( 1000 , 9999 );
          $user = new Employee();
          $user->name = ($request->name == '' ? '': $request->name);  
          $user->email = $request->email;
          $user->device_type = $request->device_type;
          $user->custom_token = $this->apiToken;
          $user->fcm_token = ($request->fcm_token == '' ? '':$request->fcm_token);
          $user->fcm_id = ($request->fcm_id == '' ? '':$request->fcm_id);
          $user->google_id = '';
          $user->facebook_id = '';
          $user->code = $code;
          $user->company_name = $request->company_name;
          $user->neq_num_of_company = $request->neq_num_of_company;
          $user->telephone = $request->telephone;
          $user->street_address = $request->street_address;
          $user->website = $request->website;
          $user->name_of_person_charge = $request->name_of_person_charge;
          $user->domain_category = $request->domain_category;
          $user->company_goal = $request->company_goal;
          $user->password = password_hash($request->password,PASSWORD_DEFAULT);
          $user->save();
          $details = Employee::where('id','=',$user->id)->first();
          return response()->json(['status' => 'success' , 'message' => "User successfully Added.", 'code' => '200', 'data' => $details],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }  
  public function forget_password(Request $request)
    {
        try {
        $data = array('mail'=>$request->email);
        $mail=urlencode(base64_encode($request->email));
        $gmail = $request->email;
        $check = Employee::where('email',$request->email)->first(); 
        $code =  mt_rand(1000,9999); 
        if(empty($check))
        {
          return response()->json(['status'=>'fail','message'=>'User not register','otp'=>'','data' =>json_decode('{}'), 'code' => '400'], 200);
        }
        else
        {
          $postArray = [ 
                    'code' => $code,
                   ];   
                  Employee::where('id','=',$check['id'])->update($postArray);
        }
            $name = $check['name'];
            $to_name = 'Employee';
            $to_email = $request->email;
            $to_subject = 'OTP For Forget password';
            $to_description = "";
            $data = array( 'name'=> $to_name ,
                                    'otp' => $code,
                                    'email' =>$to_email,
                                    'subject'=>$to_subject,
                                    'description' => $to_description);
          $key = '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';
          $template_id = 'd-e9b410841445442f9a824a03c4244d61';
          // }
          $to = 'mansi.theappideas@gmail.com';//$check['email'];
          $subject = 'TurnApp';
          $name ='mansi';
          $url = 'https://google.com';
          $json_arr = array('name'=>$name,'url_link' =>$url,'code' =>$code);
          $post_arr = array("personalizations" => array(array("to"=>array(array("email"=>$to_email)),"subject"=>$subject,"dynamic_template_data"=>$json_arr)),"from"=>array("email"=>"mansi.theappideas@gmail.com"),"content"=>array(array("type"=>"text/html","value"=>'mansi')),"template_id"=>$template_id);
            $headers = array();
            $headers[] = 'custom_token: Bearer '.$key;
            $headers[] = 'Content-Type: application/json';
            $opt = array (
              CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_POSTFIELDS => json_encode($post_arr),
              CURLOPT_POST => true,
              CURLOPT_HTTPHEADER => $headers
              );
        $ch = curl_init();
        curl_setopt_array($ch, $opt);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
          $data = [ 
                    'code' => $code,
                   ]; 
          return response()->json(['status'=>'success','message'=>'Check Your mail', 'code' => '200','data'=>$data]);
        } catch (\Exception $e) {
          return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
        } 
    }
public function logout(Request $request)
    {
      try {
        $token = $request->header('custom-token');
        $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized'], 401);
        }
        $user = Employee::where('custom_token',$token)->first();
        if($user) 
        {
          $postArray = ['custom_token' => ''];
          $logout = Employee::where('id',$user->id)->update($postArray);
          if($logout) 
          {
                return response()->json(['status'=> 'success','message'=> 'Employee Logged Out','code'=>'200']);
          }
        } 
        else 
        {
          return response()->json(['status'=> 'success','message' => 'Employee not found','code'=>'400']);
        }
        } 
        catch (\Exception $e) {
         return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
   public function changepassword(Request $request)
  {
    try {
        $postArray = [ 
                      'password' => password_hash($request->password,PASSWORD_DEFAULT),
                      'custom_token'=>$this->apiToken
                   ];   
                    $user = Employee::where('email',$request->email)->first();
              if($user) 
              {
                if(password_verify($request->old_password, $user->password)) 
                      {
                        Employee::where('email','=',$request->email)->update($postArray);
                     return response()->json(['status' => 'success' , 'message' => "Your password is successfully changed", 'code' => '200'],200);
                      }
                      else
                      {
                        return response()->json(['status' => 'error' ,'message' => 'Invalid Password', 'code' => '401'],200);
                      }
                  
              }
              else
             {
              return response()->json(['status' => 'fail' , 'message' => "User Not Found", 'code' => '400'],400);
             }
             
        } catch (\Exception $e) {
       return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
    }
  }
  public function updateprofile(Request $request)
  {
     try {
          $token = $request->header('custom-token');
           $user = chechauthemployee($token);
          // print_r($user);die;
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized'], 401);
        }
            $image = $request->file('photo');     
            $user = Employee::where('id',$user)->first();     
            if($image == '')
            {
            $imagename = $user->photo;
            }
            else
            {
                 $new_name = rand() . '.' . $image->getClientOriginalExtension();
                 $image->move(public_path('empprofileimage'), $new_name);
                 $imagename = 'public/empprofileimage/'.$new_name;
            } 
          
              $user->company_name = ($request->company_name == '' ? $user->company_name : $request->company_name);
              $user->telephone = ($request->telephone == '' ? $user->telephone : $request->telephone);
              $user->street_address  = ($request->street_address == '' ? $user->street_address : $request->street_address);
              $user->website  = ($request->website == '' ? $user->website : $request->website);
              $user->name_of_person_charge  = ($request->name_of_person_charge == '' ? $user->name_of_person_charge : $request->name_of_person_charge);
              $user->domain_category  = ($request->domain_category == '' ? $user->domain_category : $request->domain_category);
              $user->company_goal  = ($request->company_goal == '' ? $user->company_goal : $request->company_goal);
                $user->neq_num_of_company = ($request->neq_num_of_company == '' ? $user->neq_num_of_company : $request->neq_num_of_company);
              $user->photo  =$imagename;
              $user->save();
              return response()->json(['status' => 'success' , 'message' => "Your profile is successfully changed",'data'=>$user ,'code' => '200'],200);
      } catch (\Exception $e) {
       return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
    }
  }
  public function GetUserDetils(Request $request)
  {
    try
        {
          $token = $request->header('custom-token');
          $user = chechauthemployee($token);
          if(!$token || $user == '0')
          {
                return response()->json(['status' => 'fail' ,'error'=>'unauthorized','code' => '401'], 401);
          }
            $detils[] = Employee::where('id',$user)->first();
         return response()->json(['status' => 'success' , 'message' => 'sucess', 'data' => $detils, 'code' => '200'],200);
        }
        catch(\Exception $e)
        {
                return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
        }
  }
   public function verifyOtp(Request $request){
            try{

                $user = Employee::where('code',$request->code)->first();
            
                if(!empty($user)){

                  $user->is_verify = 1;
                  $user->save();
                    return response()->json(['status' => 'success' , 'message' => "Login Successfull", 'data' =>$user, 'code' => '200'],200);
                }else{
                    return response()->json(['status' => 'error' , 'message' => "Invalid OTP", 'data' =>json_decode('{}'), 'code' => '200'],200);
                }
                
            }catch(\Exception $e){
                return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
            }
        }
        public function resetpassword(Request $request)
  {
    try {
        $postArray = [ 
                      'password' => password_hash($request->password,PASSWORD_DEFAULT)
                     ];   
                    $user = Employee::where('email',$request->email)->first();
              if($user) 
              {
                  Employee::where('email','=',$request->email)->update($postArray);
              }
              else
             {
              return response()->json(['status' => 'fail' , 'message' => "Fail", 'code' => '400'],400);
             }
              return response()->json(['status' => 'success' , 'message' => "Your password is successfully changed", 'code' => '200'],200);
        } catch (\Exception $e) {
       return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
    }

  }
    public function sociallogin(Request $request)
{
  try {
                 $googleid = $request->google_id;
                 $facebookid = $request->facebook_id;
                 $email = $request->email;  
                 // print_r($facebookid);die;        
                  $validator = \Validator::make($request->all(), 
                        [                     
                      'device_type'=>'required',
                      'fcm_token'=>'required',
                      'fcm_id' =>'required'
                       ]);                 
                    if ($validator->fails()) 
                    {          
                       $message = $this->one_validation_message($validator);
                       return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
                    }
                        // user not exists
                if(Employee::check_email_exists_social($googleid,$facebookid,$email))                    
                {
                    $validator = \Validator::make($request->all(), 
                    [     
                      'email' => 'required|email|unique:users|unique:employee'
                    ]);  
                    if ($validator->fails()) 
                    {          
                       $message = $this->one_validation_message($validator);
                       return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
                    }      
                         $user = new Employee();
                         $user->name = ($request->name == '' ? '': $request->name); 
                         $user->email = ($request->email == '' ? '':$request->email);
                         $user->fcm_token = ($request->fcm_token == '' ? '':$request->fcm_token);
                         $user->device_type = ($request->device_type == '' ? '':$request->device_type);
                         $user->google_id = ($googleid == '' ? '':$googleid);
                         $user->facebook_id = ($facebookid == '' ? '':$facebookid);
                         $user->fcm_id = ($request->fcm_id == '' ? '':$request->fcm_id);
                         $user->password = password_hash('123456',PASSWORD_DEFAULT);
                         $user->custom_token = $this->apiToken;
                         /*$user->lat = ($request->lat == '' ? '' : $request->lat);
                         $user->lan = ($request->lan == '' ? '' : $request->lan);
                         $user->address = ($request->address == '' ? $user->address : $request->address);
                         $user->type = $request->type;
                         */$user->save();
                          $id = $user->id;
    $userdetails = Employee::where('id','=',$id)->first();
    return response()->json(['status' => 'success' , 'message' => "Employee successfully login", 'code' => '200', 'data' => $userdetails],200);
                }
                        // user  exists
                else
                {
                    if($googleid)
                    {
                                //echo "dd";
                                $details = Employee::where('google_id','=',$googleid)->first();    
                                $id =  $details->id;//die;    
                    }
                    if($facebookid)
                    {
                                $details = Employee::Where('facebook_id', '=', $facebookid)->first();    
                                $id = $details->id;//die;       
                    }           
                        $user = Employee::where('id','=',$id)->first();
                        /*if($request->type == '1')
                        {if($details->driver_personal_status == '1' && $details->driver_vehical_status == '1')
                        {
                            $status = '1';
                        }
                        else
                        {
                           $status =  $details->status;
                        }}
                        else
                        {
                            $status =  $details->status;
                        }*/

                        $user->device_type = ($request->device_type != '' ? $request->device_type : $details->device_type);
                        $user->fcm_token = ($request->fcm_token != '' ? $request->fcm_token : $details->fcm_token);
                        $user->fcm_id = ($request->fcm_id != '' ? $request->fcm_id : $details->fcm_id);
                        $user->name = ($request->name != '' ? $request->name : $details->name);
                        $user->email = ($request->email != '' ? $request->email : $details->email);
                        $user->google_id = ($googleid == '' ? $details->google_id:$googleid);
                         $user->facebook_id = ($facebookid == '' ? $details->facebook_id:$facebookid);
                         $user->custom_token = $this->apiToken;
                         /* $user->lat = ($request->lat == '' ? $details->lat : $request->lat);
                      $user->lan = ($request->lan == '' ? $details->lan : $request->lan);
                    $user->address = ($request->address == '' ? $details->address : $request->address);*/
                    $user->password = password_hash('123456',PASSWORD_DEFAULT);
                        $user->status = $details->status;
                        $user->save();
                        $id = $user->id;
                             $userdetails = Employee::where('id','=',$id)->first();
            
          return response()->json(['status' => 'success' , 'message' => "Employee successfully login", 'code' => '200', 'data' => $userdetails],200);
                        }

  } catch (\Exception $e) {
     return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
  }
}
public function AddUpdateCrad(Request $request)
  {
     try {
          $token = $request->header('custom-token');
           $user = chechauthemployee($token);
          // print_r($user);die;
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
                 if($request->id)
                 {
                  $user =  Bankdetails::find($request->id);   
                 }
                 else
                 {
 $user = new Bankdetails();   
                 }
              
              $user->emp_id  = $request->emp_id;
              $user->card_number  = $request->card_number;
              $user->ex_date  = $request->ex_date;
              $user->cvv  = $request->cvv;
              $user->card_holder  = $request->card_holder;
              $user->save();
              $userdetails = Bankdetails::where('emp_id','=',$request->emp_id)->get();
              return response()->json(['status' => 'success' , 'message' => "Added",'data'=>$userdetails ,'code' => '200'],200);
      } catch (\Exception $e) {
       return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
    }
  }
  public function DeleteCard(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauthemployee($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             
          $expdetils = Bankdetails::findOrFail($request->id);
          if($expdetils)
          {
            
          return response()->json(['status' => 'success' , 'message' => "Deleted", 'code' => '200'],200);  
          }
          else
          {
            return response()->json(['status' => 'success' , 'message' => "No found.", 'code' => '200'],200);
             
         }
     }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function ListCompany(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             
          $expdetils = Employee::withCount(array('countpost' => function($query) {
                    $query->where('status','1');
                }))->orderBy('id', 'desc')->get();
          return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $expdetils],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
    public function GetCompanyByid(Request $request) 
    {
      try {  
        $token = $request->header('custom-token');
           $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
             
         // $expdetils = Employee::withCount(['countpost'])->with('postdetails')->where('id',$request->id)->orderBy('id', 'desc')->get();
          $expdetils = Jobpost::withCount(['countsrequest'])->with('employeedtails')->where('status', '1')->orderBy('id', 'desc')->where('emp_id',$request->id)->get();

return response()->json(['status' => 'success' , 'message' => "sucess", 'code' => '200', 'data' => $expdetils],200);   
      }
       catch (\Exception $e) {
        return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
      }
    }
}
