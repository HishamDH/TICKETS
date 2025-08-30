<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_permission extends Model
{
    use HasFactory;
    protected $table = 'role_permissions';
    protected $fillable = ['role_id','employee_id','merchant_id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }
    
}
