<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Expdailyreport extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // id, datedone, branch, machineno, openningcode, closingcode, salescode, payoutcode, profitcode, floatcode, totalcredits, totalcollection, created_at, updated_at, previoussalesfigure, previouspayoutfigure, resetstatus, currentpayoutfigure, , ucret
   //id, expensecategory, mothname, yearname, ucret, created_at, updated_at, amount
    protected $fillable = [
        'datedone','amount', 'ucret','datedone','expensecategory'
    ];
    public function branchnameDailycodes(){
        // creating a relationship between the students model 
        return $this->belongsTo(Branch::class, 'branch'); 
    }
    public function machinenameDailycodes(){
        // creating a relationship between the students model 
        return $this->belongsTo(Machine::class, 'machineno'); 
    }
    
    
    protected $hidden = [
      //  'hid', 'id',
    ];
}
