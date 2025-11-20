<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $table = 'personal_info';
    
    public $timestamps = false; // Since your table doesn't have created_at/updated_at
    
    protected $fillable = [
        'name',
        'title',
        'location',
        'phone',
        'email',
        'github',
        'summary',
    ];
}