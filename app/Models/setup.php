<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setup extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "email",
        "phone",
        "logo",
        "social_links",
        "additional_data",

    ];
    protected $casts = [
        'social_links' => 'array',
        'additional_data' => 'array',
    ];
    
}
