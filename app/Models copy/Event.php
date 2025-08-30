<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'description',
        'category_id',
        'date',
        'location',
        'total_tickets',
        'ticket_price',
        'status',
        'user_id',
        'gallery',
        'additional_data',
    ];
    protected $casts = [
        'date' => 'datetime',
        'status' => 'string',
        'gallery'=> 'array',
        'additional_data' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getRouteKeyName()
    {
        return 'id';
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
