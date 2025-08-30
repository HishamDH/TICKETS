<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'status',
        'type',
        'user_id',
    ];
    protected $casts = [
        'status' => 'string',
        'type' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    // public function restaurents()
    // {
    //     return $this->hasMany(Restaurent::class);
    // }
    public function getRouteKeyName()
    {
        return 'slug';
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
