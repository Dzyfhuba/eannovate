<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'classes';
    protected $fillable = [
        'name',
        'major',
        'created_by',
        'updated_by'
    ];
}
