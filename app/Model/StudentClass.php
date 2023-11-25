<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = 'student_classes';

    const UPDATED_AT = null;

    protected $fillable = [
        'student_id',
        'class_id',
        'created_by',
    ];

    public function student()
    {
        return $this->belongsTo('App\Model\Student')->withDefault();
    }
    public function class()
    {
        return $this->belongsTo('App\Model\Room')->withDefault();
    }
    public function classes()
    {
        return $this->hasMany('App\Model\Room');
    }
}
