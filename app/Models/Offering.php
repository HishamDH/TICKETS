<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{
    protected $fillable = [
        'name',
        'location',
        'description',
        'image',
        'price',
        'start_time',
        'end_time',
        'status',
        'type',
        'category',
        'additional_data',
        'translations',
        'has_chairs',
        'chairs_count',
        'user_id',
        'features',
    ];

    protected $casts = [
        'additional_data' => 'array',
        'translations' => 'array',
        'features' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'has_chairs' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Reservations()
    {
        return $this->hasMany(PaidReservation::class, 'item_id');
    }
    public function Reviwes()
    {
        return $this->hasMany(Customer_Ratings::class, 'service_id');
    }
    use HasFactory;
}
