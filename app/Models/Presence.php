<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'item_id',
        'reservation_id',
        'additional_data',
    ];
    protected $casts = [
        'additional_data' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function offering()
    {
        return $this->belongsTo(Offering::class, 'item_id');
    }
    public function reservation()
    {
        return $this->belongsTo(PaidReservation::class, 'reservation_id');
    }
    
}
