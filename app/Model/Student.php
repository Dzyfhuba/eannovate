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
}
