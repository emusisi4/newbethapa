<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    //
    protected $table = 'nur_classes';
    protected $fillable = ['name'];
public function students(){
    // creating a relationship between the students model 
    return $this->hasMany(Student::class, 'studentclass', 'classno'); 
}
   


   

}
