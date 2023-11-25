<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'username',
        'email',
        'age',
        'phone_number',
        'picture',
        'created_by',
        'updated_by'
    ];

    public function studentClasses()
    {
        return $this->hasMany(StudentClass::class);
    }

    public function class()
    {
        return $this->belongsToMany(Room::class, 'student_classes', 'student_id', 'class_id');
    }
}
