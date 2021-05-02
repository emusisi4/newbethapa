<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Branchpayout extends Authenticatable
{
    use HasApiTokens, Notifiable;


  
   
    protected $fillable = [
        'amount', 'branch', 'datemade','ucret','receiptno','datepaid','bpaying',
    ];
    

    public function ExpenseTypeconnect(){
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



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      //  'hid', 'id',
    ];
}
