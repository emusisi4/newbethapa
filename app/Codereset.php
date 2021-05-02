<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Codereset extends Authenticatable
{
    use HasApiTokens, Notifiable;


     
    protected $fillable = [
        'branch', 'machinecode','ucret','machine',
        
    ];
    public function machinecoderesetMachinename(){
        // creating a relationship between the students model 
        return $this->belongsTo(Machine::class, 'machine'); 
    }
    public function machinecoderesetBranchname(){
        // creating a relationship between the students model 
        return $this->belongsTo(Branch::class, 'branch'); 
    }
























    public function branchBalancingrecord(){
        // creating a relationship between the students model 
        return $this->belongsTo(Branch::class, 'branch'); 
    }

    public function expenseCategory(){
        // creating a relationship between the students model 
        return $this->belongsTo(Branch::class, 'bpaying'); 
    }
    public function payingUserdetails(){
        // creating a relationship between the students model 
        return $this->belongsTo(User::class, 'ucret'); 
    }
    public function userbalancingBranch(){
        // creating a relationship between the students model 
        return $this->belongsTo(User::class, 'ucret'); 
    }
    public function branchinBalance(){
        // creating a relationship between the students model 
        return $this->belongsTo(Branch::class, 'branch'); 
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
