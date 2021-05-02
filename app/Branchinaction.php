<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Branchinaction extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['branch','ucret',
    ];
    //public function maincomponentSubmenus(){
        // creating a relationship between the students model 
      //  return $this->belongsTo(Mainmenucomponent::class, 'mainheadercategory'); 
 //   }

    protected $hidden = [
      //  'hid', 'id',
    ];
}
