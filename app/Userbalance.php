<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Userbalance extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username','amount','description',
        'ucret',
    ];
    //public function maincomponentSubmenus(){
        // creating a relationship between the students model 
      //  return $this->belongsTo(Mainmenucomponent::class, 'mainheadercategory'); 
 //   }

 public function usernameBalance(){
    // creating a relationship between the students model 
    return $this->belongsTo(User::class, 'username'); 
}

    protected $hidden = [
      //  'hid', 'id',
    ];
}
