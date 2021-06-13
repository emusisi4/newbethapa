<?php


namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Expensetype extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'typename', 'description', 'ucret',
    ];
    
    public function students(){
      // creating a relationship between the students model 
      return $this->hasMany(Expense::class, 'expensetype', 'id'); 
  }
   
  public function expenseTyperpt(){
    return $this->hasMany(Madeexpense::class, 'exptype', 'id'); 
  }
    protected $hidden = [
      //  'hid', 'id',
    ];
}