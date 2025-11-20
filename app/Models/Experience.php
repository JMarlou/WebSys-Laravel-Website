<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experience';
    public $timestamps = false;
    
    protected $fillable = [
        'description',
        'user_id',
    ];
}