<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'report_id','path'
    ];

    // public function type ()
    // {
    //     return $this->hasOne('App\Type');
    // }

    // public function types()
    // {
    //     return $this->hasMany('App\Type');
    // }
    

}
