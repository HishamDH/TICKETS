<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_Ratings extends Model
{
    use HasFactory;
    //protected $table = 'customer__ratings';
    protected $fillable = [
        'user_id',
        'service_id',
        'rating',
        'review',
        'is_visible',
        'additional_data'
    ];
    protected $casts = [
        'additional_data' => 'array',
        'is_visible' => 'boolean',
        'rating' => 'float',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Offering::class, 'service_id');
    }

}
