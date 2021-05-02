<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

   
    protected $fillable = [
        'companyname', 'companycontact','emailaddress','del'
       
    ];
    

    public function suppliers(){
        // creating a relationship between the students model 
        return $this->hasMany(Supplier::class, 'Company', 'id'); 
    }
         

    public function students(){
        // creating a relationship between the students model 
        return $this->hasMany(Supplier::class, 'Company', 'id'); 
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
