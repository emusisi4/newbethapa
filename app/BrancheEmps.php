<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BrancheEmps extends Model
{
    //
     protected $table = 'empbranches';
    protected $fillable = [
        'branch',
        'name'
    ];

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
