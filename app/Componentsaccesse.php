<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Componentsaccesse extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['componentto',
        'mmaderole', 'ucret',
    ];
    //public function maincomponentSubmenus(){
        // creating a relationship between the students model 
      //  return $this->belongsTo(Mainmenucomponent::class, 'mainheadercategory'); 
 //   }

 public function students(){
  // creating a relationship between the students model 
  return $this->hasMany(Branchpayout::class, 'branchno', 'branch'); 
}

public function branchcintranfers(){
  // creating a relationship between the students model 
  return $this->hasMany(Cintransfer::class, 'branchno', 'branchto'); 
}
public function branchcintranferfrom(){
  // creating a relationship between the students model 
  return $this->hasMany(Cintransfer::class, 'branchno', 'branchfrom'); 
}


public function busers(){
  // creating a relationship between the students model 
  return $this->hasMany(User::class, 'branchno', 'branch'); 
}
public function brnchbalancingrecords(){
  // creating a relationship between the students model 
  return $this->hasMany(Shopbalancingrecord::class, 'branchno', 'branch'); 
}

    protected $hidden = [
      //  'hid', 'id',
    ];
}
