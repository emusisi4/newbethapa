<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Expmothlyexpensereport extends Authenticatable
{
    use HasApiTokens, Notifiable;

   
    protected $fillable = [
       
      'monthname', 'yearname', 'amount', 'ucret', 'branch'
       
    ];
    


    protected $hidden = [
      //  'hid', 'id',
    ];
    public function branchnameDailycodes(){
        // creating a relationship between the students model 
        return $this->belongsTo(Branch::class, 'branch'); 
    }
}
