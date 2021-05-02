<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Machine extends Authenticatable
{
    use HasApiTokens, Notifiable;


    
    protected $fillable = [
        'machinename','ucret','description',
    ];
    
    public function machinenameDailycodes(){
        // creating a relationship between the students model 
        return $this->hasMany(Dailyreportcode::class, 'id', 'machineno'); 
      }
    public function machinecoderesetMachinename(){
        // creating a relationship between the students model 
        return $this->hasMany(Codereset::class, 'id', 'machine'); 
      }
    public function machinenameBranchmachines(){
        // creating a relationship between the students model 
        return $this->hasMany(Branchandmachine::class, 'id', 'machinename'); 
      }

    public function expenseName(){
        // creating a relationship between the students model 
        return $this->belongsTo(Expense::class, 'expense'); 
    }
    public function branchName(){
        // creating a relationship between the students model 
        return $this->belongsTo(Branch::class, 'branch'); 
    }
    public function ExpenseTypeconnect(){
        // creating a relationship between the students model 
        return $this->belongsTo(ExpenseType::class, 'expensetype'); 
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
