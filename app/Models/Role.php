<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['key','created_by','additional_data'];

    protected $casts = ['additional_data' => 'array'];

    /**
     * The permissions that belong to the role.
     */
    //  public function permissions()
    //  {
    //      return $this->belongsTo(Permission::class, 'role_permissions')
    //          ->withTimestamps()
    // ->withPivot('additional_data');
    //  }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

}
