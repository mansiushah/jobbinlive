<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eduction extends Model
{
   public $timestamps = false; 
   protected $table = 'eductions';
   protected $fillable = [
        'title'
    ];
}
