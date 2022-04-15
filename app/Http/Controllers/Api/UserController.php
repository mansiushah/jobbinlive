<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Experience;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Validator;
use Mail;
use DB;

class UserController extends Controller
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
                  $user = User::where('email',$request->username)->orwhere('name',$request->username)->first();
                  if($user) 
                  {
                      if(password_verify($request->password, $user->password)) 
                      {
                        $postArray = ['custom_token' => $this->apiToken,'fcm_token'=>($request->fcm_token == '' ?'':$request->fcm_token),'device_type'=>$request->device_type];
                        $login = User::where('email',$request->username)->orwhere('name',$request->username)->update($postArray);          
                        if($login && $user->status == '1') 
                        {
                          $user1 = User::where('email',$request->username)->orwhere('name',$request->username)->first();
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
                    'name'=>'required',
                    'email' => 'unique:users',
                    'password' => 'required',
                 ]);                 
          if ($validator->fails()) 
          {          
             $message = $this->one_validation_message($validator);
             return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
          }     
           $code = rand ( 1000 , 9999 );
          $user = new User();
          $user->name = ($request->name == '' ? '': $request->name);  
          $user->email = $request->email;
          $user->role = $request->role;
          $user->device_type = $request->device_type;
          $user->custom_token = $this->apiToken;
          $user->fcm_token = ($request->fcm_token == '' ? '':$request->fcm_token);
          $user->fcm_id = ($request->fcm_id == '' ? '':$request->fcm_id);
          $user->google_id = '';
          $user->facebook_id = '';
          $user->code = $code;
          $user->password = password_hash($request->password,PASSWORD_DEFAULT);
          $user->save();
          $details = User::where('id','=',$user->id)->first();
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
        $check = User::where('email',$request->email)->first(); 
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
                  User::where('id','=',$check['id'])->update($postArray);
        }
            $name = $check['name'];
            $to_name = 'User';
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
        $user = chechauth($token);
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized'], 401);
        }
        $user = User::where('custom_token',$token)->first();
        if($user) 
        {
          $postArray = ['custom_token' => ''];
          $logout = User::where('id',$user->id)->update($postArray);
          if($logout) 
          {
                return response()->json(['status'=> 'success','message'=> 'User Logged Out','code'=>'200']);
          }
        } 
        else 
        {
          return response()->json(['status'=> 'success','message' => 'User not found','code'=>'400']);
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
                    $user = User::where('email',$request->email)->first();
              if($user) 
              {
                if(password_verify($request->old_password, $user->password)) 
                      {
                        User::where('email','=',$request->email)->update($postArray);
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
  public function myeduction(Request $request)
  {
     try {
          $token = $request->header('custom-token');
           $user = chechauth($token);
          // print_r($user);die;
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
                 
            $user = User::where('id',$user)->first();    
              $user->skills = ($request->skills == '' ? $user->skills : $request->skills);
              $user->education  = ($request->education == '' ? $user->education : $request->education);
              $user->eduction_bio  = ($request->eduction_bio == '' ? $user->bio : $request->eduction_bio);
              $user->save();
              return response()->json(['status' => 'success' , 'message' => "Your profile is successfully changed",'data'=>$user ,'code' => '200'],200);
      } catch (\Exception $e) {
       return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
    }
  }
  public function updateprofile(Request $request)
  {
     try {
          $token = $request->header('custom-token');
           $user = chechauth($token);
          // print_r($user);die;
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
            $image = $request->file('photo');     
            $user = User::where('id',$user)->first();    
            if($image == '')
            {
            $imagename = $user->photo;
            }
            else
            {
                 $new_name = rand() . '.' . $image->getClientOriginalExtension();
                 $image->move(public_path('profileimage'), $new_name);
                 $imagename = 'public/profileimage/'.$new_name;
            } 
              $user->bod = ($request->bod == '' ? $user->bod : $request->bod);
              $user->name = ($request->name == '' ? $user->name : $request->name);
              $user->photo = $imagename;
              $user->phone  = ($request->phone == '' ? $user->phone : $request->phone);
              $user->address  = ($request->address == '' ? $user->address : $request->address);
              $user->bio  = ($request->bio == '' ? $user->bio : $request->bio);
              $user->gender  = ($request->gender == '' ? $user->gender : $request->gender);
              $user->delegate  = ($request->delegate == '' ? $user->delegate : $request->delegate);
              $user->save();
              return response()->json(['status' => 'success' , 'message' => "Your profile is successfully changed",'data'=>$user ,'code' => '200'],200);
      } catch (\Exception $e) {
       return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
    }
  }
  public function idProofUpload(Request $request)
  {
     try {
          $token = $request->header('custom-token');
           $user = chechauth($token);
          // print_r($user);die;
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
                 
            $image = $request->file('idproof');     
            $user = User::where('id',$user)->first();    
            if($image == '')
            {
            $imagename = $user->idproof;
            }
            else
            {
                 $new_name = rand() . '.' . $image->getClientOriginalExtension();
                 $image->move(public_path('idproof'), $new_name);
                 $imagename = 'public/idproof/'.$new_name;
            } 
              $user->idproof = $imagename;
              $user->save();
              return response()->json(['status' => 'success' , 'message' => "Your profile is successfully Added",'data'=>$user ,'code' => '200'],200);
      } catch (\Exception $e) {
       return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
    }
  }
  public function selectpreference(Request $request)
  {
     try {
          $token = $request->header('custom-token');
           $user = chechauth($token);
          // print_r($user);die;
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
            $user = User::where('id',$user)->first();    
            $user->preference = $request->preference;
            $user->save();
              return response()->json(['status' => 'success' , 'message' => "Your Intrested is successfully Added",'data'=>$user ,'code' => '200'],200);
      } catch (\Exception $e) {
       return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
    }
  }
  public function addExperience(Request $request)
  {
     try {
          $token = $request->header('custom-token');
           $user = chechauth($token);
          // print_r($user);die;
        if(!$token || $user == '0' )
        {
            return response()->json(['error'=>'unauthorized1'], 401);
        }
               
            /* $experience = json_decode($request->experience);
        $i =1;        
      foreach ($experience as $key => $value) 
      {

           $insert[$i]['company_name'] =  $value->company_name;
           $insert[$i]['start_date'] = $value->startDate;
           $insert[$i]['end_date'] = $value->endDate;
            $insert[$i]['location'] = $value->location;
           $insert[$i]['user_id'] = $user;
          $i++;
      }
       $check = Experience::insert($insert);*/
       $Experience = User::where('id',$user)->first();    
       $Experience->experience = $request->experience;
       $Experience->save();
       
        $expdetils = User::GetUserProfile($user);

              return response()->json(['status' => 'success' , 'message' => "Added",'data'=>$expdetils ,'code' => '200'],200);
      } catch (\Exception $e) {
       return response()->json(['status' => 'fail' ,'message'=>$e->getMessage(), 'code' => '404'], 404);
    }
  }
  public function GetUserDetils(Request $request)
  {
    try
        {
          $token = $request->header('custom-token');
          $user = chechauth($token);
          if(!$token || $user == '0')
          {
                return response()->json(['status' => 'fail' ,'error'=>'unauthorized','code' => '401'], 401);
          }
            $detils[] = User::where('id',$user)->first();
         return response()->json(['status' => 'success' , 'message' => 'sucess', 'data' => $detils, 'code' => '200'],200);
        }
        catch(\Exception $e)
        {
                return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
        }
  }
   public function verifyOtp(Request $request){
            try{

                $user = User::where('code',$request->code)->first();
            
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
                    $user = User::where('email',$request->email)->first();
              if($user) 
              {
                  User::where('email','=',$request->email)->update($postArray);
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
  public function GetIntrests(Request $request)
  {
    try
        {
          $token = request()->header('custom-token');
          $user = chechauth($token);
          if(!$token || $user == '0')
          {
                return response()->json(['status' => 'fail' ,'error'=>'unauthorized','code' => '401'], 401);
          }
          $detailsUser = User::GetUserProfile($user);
          $iTTo = $detailsUser->intrested_topics;
          $topics = explode(',',$iTTo);
          //print_r($topics);die;
            $detils = Intrests::get()->toArray();
            foreach ($detils as  $value) 
            {
               if(in_array($value['id'], $topics)) { $selected = true; } else { $selected = false; }
                $array[] = array('id'=>$value['id'],'title'=>$value['title'],'image'=>$value['image'],'isSelected'=>$selected);
            }
         return response()->json(['status' => 'success' , 'message' => 'sucess', 'data' => $array, 'code' => '200'],200);
        }
        catch(\Exception $e)
        {
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
                if(User::check_email_exists_social($googleid,$facebookid,$email))                    
                {
                    $validator = \Validator::make($request->all(), 
                    [     
                      'email' => 'required|email|unique:users'
                    ]);  
                    if ($validator->fails()) 
                    {          
                       $message = $this->one_validation_message($validator);
                       return response()->json(['status' => 'fail' , 'message' => $message, 'data' => json_decode('{}'), 'code' => '401'],200);        
                    }      
                         $user = new User();
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
    $userdetails = User::where('id','=',$id)->first();
    return response()->json(['status' => 'success' , 'message' => "User successfully login", 'code' => '200', 'data' => $userdetails],200);
                }
                        // user  exists
                else
                {
                    if($googleid)
                    {
                                //echo "dd";
                                $details = User::where('google_id','=',$googleid)->first();    
                                $id =  $details->id;//die;    
                    }
                    if($facebookid)
                    {
                                $details = User::Where('facebook_id', '=', $facebookid)->first();    
                                $id = $details->id;//die;       
                    }           
                        $user = User::where('id','=',$id)->first();
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
                             $userdetails = User::where('id','=',$id)->first();
            
          return response()->json(['status' => 'success' , 'message' => "User successfully login", 'code' => '200', 'data' => $userdetails],200);
                        }

  } catch (\Exception $e) {
     return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
  }
}


}
