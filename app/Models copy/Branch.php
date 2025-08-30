<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'location',
        'tables',
        'hour_price',
        'open_at',
        'close_at',
        'status',
        'restaurant_id',
        'gallery'
    ];
    protected $casts = [
    'gallery' => 'array',
    ];
    public function restaurant()
    {
        return $this->belongsTo(User::class, 'restaurant_id');
    }
    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }

}
