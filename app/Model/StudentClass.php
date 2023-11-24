<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    public function student()
    {
        return $this->belongsTo('App\Model\Student')->withDefault();
    }
    public function class()
    {
        return $this->belongsTo('App\Model\Class')->withDefault();
    }
}
