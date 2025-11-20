<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';
    public $timestamps = false;
    
    protected $fillable = [
        'skill',
        'user_id',
    ];
}