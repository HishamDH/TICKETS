<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Merchant\Branch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Role;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'email',
        'business_name',
        'business_type',
        'email_verified_at',
        'password',
        'role',
        'phone',
        'additional_data',
        // 'is_accepted',
        'status',
        'status_updated_at',
        'rejection_reason',
        'acceptance_note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'additional_data' => 'array',
    ];
    /**
     * Get the events created by the user.
     */


    // public function getAdditionalDataAttribute($value)
    // {
    //     return json_decode($value, true);
    // }
    public function carts(){
        return $this->hasMany(Cart::class,'user_id','id');
    }
    public function branches(){
        return $this->hasMany(Branch::class,'user_id','id');
    }
    public function offers(){
        return $this->hasMany(Offering::class,'user_id');
    }
    public function isMerchant()
    {
        return $this->hasRole('merchant');
    }
    // public function getRolesAttribute()
    // {
    //     $data = json_decode($this->additional_data, true);
    //     $roleIds = $data['roles'] ?? [];
    
    //     return Role::whereIn('id', $roleIds)->get();
    // }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function wallet()
    {
        return $this->hasOne(MerchantWallet::class, 'merchant_id', 'id');
    }
    public function reviews()
    {
        return $this->hasManyThrough(
            Customer_Ratings::class,
            Offering::class,
            'user_id',   
            'service_id',  
            'id',       
            'id'  
        );
    }


}
