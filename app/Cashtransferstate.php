<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cashtransferstate extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ucret',
    ];
    

   
    public function statusName(){
        // creating a relationship between the students model 
        return $this->belongsTo(Cintransfer::class, 'id'); 
    }

    public function statusNameout(){
        // creating a relationship between the students model 
        return $this->belongsTo(Couttransfer::class, 'id'); 
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
