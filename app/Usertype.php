<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usertype extends Authenticatable
{
    use HasApiTokens, Notifiable;


    protected $fillable = ['typename','rolename','roleid','description','roletype'];
    protected $hidden = [
      //  'hid', 'id',
    ];
}
