<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Expensesreporttoviewdetail extends Authenticatable
{
    use HasApiTokens, Notifiable;

   
    protected $fillable = [
      
      'startdate', 'enddate', 'branch', 'monthname', 'ucret', 'yearname', 'walletname', 
      'categoryname', 'typename', 'sortby'
       
    ];
    


    protected $hidden = [
      //  'hid', 'id',
    ];
}
