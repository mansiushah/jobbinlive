<?php

use App\Models\User;
use App\Models\Employee;

 
 function chechauth($token)
{
     $user = User::where('custom_token',$token)->first();
      if($user)
    {
        return $user->id;
    }
    else
    {
        return 0;
    }
}
function chechauthemployee($token)
{
     $user = Employee::where('custom_token',$token)->first();
      if($user)
    {
        return $user->id;
    }
    else
    {
        return 0;
    }
}
function SEND_FCM_NOTIFICATION_IOS($registration_id,$data) 
{
    $registrationIds[] = $registration_id;
       if (!defined('FIREBASE_API_KEY')) define("FIREBASE_API_KEY", "AAAA01fEtzQ:APA91bHQs_fBEWgUhZA81PNzU7_hlnHdu2ytarkbCeW-zsuZTLYCQ8zMD4Y_qJvTstIoLpFwMtka8F8ME6unwBHwHpHiHjfD7ex21b1kPzRz9gnfjNZV7GjoYQSYt7kbxCBB3rP25vGx");
       if (!defined('FIREBASE_FCM_URL')) define("FIREBASE_FCM_URL", "https://fcm.googleapis.com/fcm/send");
             $notification = [
'title' =>$data['title'],
'body' => $data['message'],
'vibrate'   => '1',
'sound' => '1'
];
$data1 = [
'notification' => $notification,
'data' => $data,
'title' =>$data['title'],
'body' => $data['message']
];

      $fields = array('data' => $data1, 'notification' => $data1,'registration_ids' => $registrationIds);
        $headers = array(
            'Authorization: key=' . FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, FIREBASE_FCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Problem occurred: ' . curl_error($ch));
        }
        curl_close($ch);

}
?>