<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
     protected $table = 'employee';
     public $timestamps = false;
     public static function check_email_exists_social($googleid,$facebookid,$email)
    {
      //  DB::enableQueryLog(); // Enable query log
        $query = Employee::where('google_id','=',$googleid)->where('email',$email)->first();
           //  dd(DB::getQueryLog()); // Show results of log
        $queryto = Employee::Where('facebook_id', '=', $facebookid)->where('email',$email)->first();  
            if(empty($query))
            {
               return true;
            }
             else
            {
             return false;
            }
            if(empty($queryto))
            { 
                return true;
            }
            else
            {
                return false;
            }
    }
     public function countpost()
    {
       return $this->hasMany(Jobpost::class, 'emp_id', 'id');    
    }
    public function postdetails()
    {
       return $this->hasMany(Jobpost::class, 'emp_id', 'id');    
    }
   
}
