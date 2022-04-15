<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobpost extends Model
{
     protected $table = 'job_post';
     public $timestamps = false; 
    
    public function employeedtails()
    {
       return $this->hasOne(Employee::class, 'id', 'emp_id');    
    }
    public function userdetails()
    {
       return $this->hasOne(User::class, 'id', 'userid')->withDefault();    
    }
     public function employeedtailsfilter()
    {
       //return $this->belongsToMany(Employee::class);    
         return $this->belongsToMany(Employee::class, 'job_post', 'id', 'emp_id');

    }
    public function countsrequest()
    {
       return $this->hasMany(Jobrequest::class, 'post_id', 'id');    
    }
      public function username()
    {
       //return $this->belongsToMany(Employee::class);    
         return $this->belongsTo(User::class);

    }
    public function rateInfo()
    {
        return $this->hasMany(Rating::class, 'emp_id','emp_id');
    }
     public function flag()
    {
        return $this->hasOne(Favorite::class, 'post_id', 'id');
    }
}
