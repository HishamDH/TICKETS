<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class page_views extends Model
{
    use HasFactory;
    protected $table = 'page_views';
    protected $fillable = [
        'user_id',
        'ip_address',
        'page_url',
        'merchant_id',
        'additional_data'
    ];
    protected $casts = [
        'additional_data' => 'array',
        'ip_address' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }
    
}
