<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Branchanduser extends Authenticatable
{
    use HasApiTokens, Notifiable;


    protected $fillable = [
        'branchname', 'ucret','username'
    ];
    

    public function branchandUsername(){
        // creating a relationship between the students model 
        return $this->belongsTo(User::class, 'username'); 
    }

    public function branchanduserBranchname(){
        // creating a relationship between the students model 
        return $this->belongsTo(Branch::class, 'branchname'); 
    }



   
    protected $hidden = [
      //  'hid', 'id',
    ];
}
