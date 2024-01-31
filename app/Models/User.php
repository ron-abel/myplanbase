<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public const SUPERADMIN = 1;
    public const TENANT_MANAGER = 2;
    public const TENANT_OWNER = 3;
    public const TENANT_SUPPORTER = 4;
    public const TENANT_VIEWER = 5;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'contractor_id', 'user_role_id', 'admin_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'admin_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, "id");
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, "user_role_id");
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->contractor->sub_domain));
    }
}
