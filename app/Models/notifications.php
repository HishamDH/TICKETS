<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'type', 
        'is_read',
        'additional_data'
    ];
    protected $casts = [
        'additional_data' => 'array',
        'is_read' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
