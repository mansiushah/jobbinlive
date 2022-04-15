<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false; 
    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
    ];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
  
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function GetUserProfile($userid)
    {
       // echo $id;die;
        $data = User::where('id',$userid)->first();
        return $data;
    }
    public static function check_email_exists_social($googleid,$facebookid,$email)
    {
      //  DB::enableQueryLog(); // Enable query log
        $query = User::where('google_id','=',$googleid)->where('email',$email)->first();
           //  dd(DB::getQueryLog()); // Show results of log
        $queryto = User::Where('facebook_id', '=', $facebookid)->where('email',$email)->first();  
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
     
}