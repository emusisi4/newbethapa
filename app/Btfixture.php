<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Btfixture extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'hometeam','awayteam','gamedate','league','gametime', 'status', 'datemade','ucret','gameno','feedgameno',
    ];
    
/// Looking ar the home team
    public function homeTeamname(){
        // creating a relationship between the students model 
        return $this->belongsTo(Btteam::class, 'hometeam'); 
    }
    public function awayTeamname(){
        // creating a relationship between the students model 
        return $this->belongsTo(Btteam::class, 'awayteam'); 
    }

    public function LeagueName(){
        // creating a relationship between the students model 
        return $this->belongsTo(Btteam::class, 'awayteam'); 
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
