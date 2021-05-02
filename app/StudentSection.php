<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class StudentSection extends Model
{
    //
    protected $table = 'ssection';
    protected $fillable = ['name'];
    public function students(){
        // creating a relationship between the students model 
        return $this->hasMany(Student::class, 'ssection', 'id'); 
    }

   

}
