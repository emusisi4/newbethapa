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
        
        'monthname','yearname','amount','branch','ucret'
    ];
    

    public function expenseName(){
        
        return $this->belongsTo(Expense::class, 'expense'); 
    }
    public function branchName(){
      
        return $this->belongsTo(Branch::class, 'branch'); 
    }
    public function ExpenseTypeconnect(){
     
        return $this->belongsTo(ExpenseType::class, 'expensetype'); 
    }
    public function expenseCategory(){
      
        return $this->belongsTo(Expensescategory::class, 'expensecategory'); 
    }



   
    protected $hidden = [
      //  'hid', 'id',
    ];
}
