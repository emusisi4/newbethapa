<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
     protected $table = 'students';
    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'studentclass',
        'fathername',
        'fathercontact',
        'residence',
        'dob',
        'entrydate',
        'nok',
        'nokcontact',
        'foccupation',
        'pno',
        'mothersname',
        'moccupation',
        'studentno',
        'primarycontactname',
        'primarycontact',
        'healthdescrition',
        'anycoronicaldisease',
        'ucret',
        'ssection',
        'formerschool',
        'entrydate',
        'gender',

        'mcontact'
    ];
    public function studentClass(){
        // creating a relationship between the students model 
        return $this->belongsTo(StudentClass::class, 'studentclass'); 
    }

    public function studentSection(){
        // creating a relationship between the students model 
        return $this->belongsTo(StudentSection::class, 'ssection'); 
    }

    public static function getExcerpt($str, $startPos = 0, $maxLength = 50) {
        if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength - 6);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= ' [...]';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }

}
