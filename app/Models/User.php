<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;

/**
 * Class User
 * @package App\Models
 * @version April 4, 2022, 8:22 am UTC
 *
 */
class User extends Authenticatable  implements MustVerifyEmail
{
    use HasFactory, HasApiTokens, Notifiable;

    public $table = 'users';

    protected $dates = ['deleted_at'];

    public $fillable = [
            'name',
            'email',
            'password',
            'role_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $visible = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'role'
    ];

    protected $appends = [ 'role' ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role_id == Role::Admin;
    }

    /**
     * @return bool
     */
    public function getRoleAttribute()
    {
        return Role::getRoleTitle($this->role_id);
    }
}
