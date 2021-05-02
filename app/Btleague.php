<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Btleague extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'sysid', 'feedid','countryid','countryfeedif','description','badge',
    ];
    

    //public function FixturehomeTeam(){
        // creating a relationship between the students model 
      //  return $this->belongsTo(Btfixture::class, 'sysid'); 
   // }
   public function leagueName(){
    // creating a relationship between the students model 
    return $this->belongsTo(Btleague::class, 'sysid'); 
}
    public function FixtureawayTeam(){
        // creating a relationship between the students model 
        return $this->belongsTo(Btfixture::class, 'sysid'); 
    }
    public function expenseCategory(){
        // creating a relationship between the students model 
        return $this->belongsTo(Expensescategory::class, 'expensecategory'); 
    }



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      //  'hid', 'id',
    ];
}
