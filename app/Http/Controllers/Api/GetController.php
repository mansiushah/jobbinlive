<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Experience;
use App\Models\Preference;
use App\Models\Skills;
use App\Models\Eduction;
use App\Models\Subscription;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Validator;
use Mail;
use DB;
use File;
class GetController extends Controller
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
    
    public function ListPreference(Request $request) 
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
          $iTTo = $detailsUser->preference;
          $topics = explode(',',$iTTo);
          //print_r($topics);die;
          $title = $request->title;
           $detils = Preference::get()->toArray();
          if($title)
          {
            $detils = Preference::where('title','LIKE','%'.$title.'%')->get()->toArray();
          }
           
            foreach ($detils as  $value) 
            {
               if(in_array($value['id'], $topics)) { $selected = true; } else { $selected = false; }
                $array[] = array('id'=>$value['id'],'title'=>$value['title'],'isSelected'=>$selected);
            }
         return response()->json(['status' => 'success' , 'message' => 'sucess', 'data' => $array, 'code' => '200'],200);
        }
        catch(\Exception $e)
        {
                return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
        }
    }
    public function ListSkills(Request $request) 
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
          $iTTo = $detailsUser->skills;
          $topics = explode(',',$iTTo);
          //print_r($topics);die;
            $detils = Skills::get()->toArray();
            foreach ($detils as  $value) 
            {
               if(in_array($value['id'], $topics)) { $selected = true; } else { $selected = false; }
                $array[] = array('id'=>$value['id'],'title'=>$value['title'],'isSelected'=>$selected);
            }
         return response()->json(['status' => 'success' , 'message' => 'sucess', 'data' => $array, 'code' => '200'],200);
        }
        catch(\Exception $e)
        {
                return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
        }
    }
    public function ListEduction(Request $request) 
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
          $iTTo = $detailsUser->education;
          $topics = explode(',',$iTTo);
          //print_r($topics);die;
            $detils = Eduction::get()->toArray();
            foreach ($detils as  $value) 
            {
               if(in_array($value['id'], $topics)) { $selected = true; } else { $selected = false; }
                $array[] = array('id'=>$value['id'],'title'=>$value['title'],'isSelected'=>$selected);
            }
         return response()->json(['status' => 'success' , 'message' => 'sucess', 'data' => $array, 'code' => '200'],200);
        }
        catch(\Exception $e)
        {
                return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
        }
    }
     public function ListSubscription(Request $request) 
    {
     try
        {
          $token = request()->header('custom-token');
          $user = chechauthemployee($token);
          if(!$token || $user == '0')
          {
                return response()->json(['status' => 'fail' ,'error'=>'unauthorized','code' => '401'], 401);
          }
          /*$detailsUser = User::GetUserProfile($user);
          $iTTo = $detailsUser->education;
          $topics = explode(',',$iTTo);*/
          //print_r($topics);die;
            $detils = Subscription::get()->toArray();
            /*foreach ($detils as  $value) 
            {
               if(in_array($value['id'], $topics)) { $selected = true; } else { $selected = false; }
                $array[] = array('id'=>$value['id'],'title'=>$value['title'],'isSelected'=>$selected);
            }*/
         return response()->json(['status' => 'success' , 'message' => 'sucess', 'data' => $detils, 'code' => '200'],200);
        }
        catch(\Exception $e)
        {
                return response()->json(['status' => 'error' , 'message' => $e->getMessage(), 'data' => json_decode('{}'), 'code' => '500'],200);
        }
    }
}
