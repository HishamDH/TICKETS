<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_id',
        'user_id',
        'reservation_date',
        'start_time',
        'end_time',
        'price',
        'chairs',
        'status',
        'additional_data',
        'code'
    ];
    protected $casts = [
        'reservation_date' => 'date',
        // 'start_time' => 'time',
        // 'end_time' => 'time',
        'additional_data' => 'array',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getStartTimeAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $value);
    }

    public function getEndTimeAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $value);
    }

}
