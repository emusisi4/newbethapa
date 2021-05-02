<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rolenaccmain extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'component','roleto','ucret',
    ];
    public function mainmName(){
        // creating a relationship between the students model 
        return $this->belongsTo(Mainmenucomponent::class, 'component'); 
    }

    public function ExpenseTypeconnect(){
        // creating a relationship between the students model 
        return $this->belongsTo(ExpenseType::class, 'expensetype'); 
    }
    public function maincomponentSubmenus(){
        // creating a relationship between the students model 
        return $this->belongsTo(Mainmenucomponent::class, 'id'); 
    }


    protected $hidden = [
      //  'hid', 'id',
    ];
}
