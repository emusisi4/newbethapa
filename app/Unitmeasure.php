<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Unitmeasure extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

   
    protected $fillable = [
        'unitname', 'shotcode', 'ucret',
       
    ];
    

    public function students(){
   
        return $this->hasMany(Product::class, 'unitmeasure', 'id'); 
    }
    public function supp(){
        // creating a relationship between the students model 
        return $this->belongsTo(Product::class, 'supplier'); 
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
