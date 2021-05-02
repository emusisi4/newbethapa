<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Madeexpense extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expense','explevel','walletexpense','category','exptype', 'amount', 'datemade','ucret','branch','description','approvalstate',
    ];
    

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
