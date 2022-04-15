<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobrequest extends Model
{
     protected $table = 'job_post_requests';
     public $timestamps = false; 
    
    public function userdetails()
    {
       return $this->hasOne(User::class, 'id', 'candidate_id');    
    }
}
