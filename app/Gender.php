<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    //
    protected $table = 'genders';
    protected $fillable = ['name'];

   

}
