<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ExpenseWalet extends Model
{
    //
     protected $table = 'expensewalets';
    protected $fillable = ['name'];
//public function students(){
    // creating a relationship between the students model 
  //  return $this->hasMany(Student::class, 'studentclass', 'classno'); 
//}
   


   

}
