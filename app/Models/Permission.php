<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['name','additional_data'];

    protected $casts = ['additional_data' => 'array'];
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'role_permissions')
    //         ->withTimestamps()
    //         ->withPivot('additional_data');
    // }
}
