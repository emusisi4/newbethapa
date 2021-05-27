<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Companydetail extends Authenticatable
{
    use HasApiTokens, Notifiable;

   
    protected $fillable = [
        'companyname', 'currency','ucret','currencysymbol','logo'
        
    ];
    public function students(){
        // creating a relationship between the students model 
        return $this->hasMany(Product::class, 'brand', 'id'); 
    }
       
    public function cbscde(){
      
        return $this->hasMany(Ordermaking::class, 'brand', 'id'); 
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
