<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rolenaccsumbmen extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'component','roleto','ucret','mainheader',
    ];
    
    public function submName(){
        // creating a relationship between the students model 
        return $this->belongsTo(Submheader::class, 'component'); 
    }
    public function ExpenseTypeconnect(){
        // creating a relationship between the students model 
        return $this->belongsTo(ExpenseType::class, 'expensetype'); 
    }
    public function maincomponentSubmenus(){
        // creating a relationship between the students model 
        return $this->belongsTo(Mainmenucomponent::class, 'id'); 
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
