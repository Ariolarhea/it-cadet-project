<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
       'title', 'detail','date_posted','posted_by','company','department'
    ];
    
    public function attachment ()
    {
        return $this->hasOne('App\Attachment');
    }
}