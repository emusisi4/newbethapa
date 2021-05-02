<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Submheader extends Authenticatable
{
    use HasApiTokens, Notifiable;


    public function students(){
        // creating a relationship between the students model 
        return $this->hasMany(Rolenaccsumbmen::class, 'id', 'component'); 
    }
    
    protected $fillable = [
        'submenuname', 'mainheadercategory', 'shid','ucret','dorder','linkrouterre','description',
    ];
    public function maincomponentSubmenus(){
        // creating a relationship between the students model 
        return $this->belongsTo(Mainmenucomponent::class, 'mainheadercategory'); 
    }
    protected $hidden = [
      //  'hid', 'id',
    ];
}
