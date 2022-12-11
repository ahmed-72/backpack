<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    
    /**
     * The attributes that should be cast.
     *
     * @var json <string, string>
    */
    protected $casts = [
        'cinfig' => 'array',
    ];
}
