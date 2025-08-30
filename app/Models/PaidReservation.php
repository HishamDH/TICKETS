<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidReservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'item_type',
        'user_id',
        'quantity',
        'price',
        'discount',
        'code',
        'additional_data',
    ];

    public function offering()
    {
        return $this->belongsTo(Offering::class, 'item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
