<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


/**
 * Class User
 * @package App\Models
 * @version April 4, 2022, 8:22 am UTC
 *
 */
class User extends Authenticatable
{
    use HasFactory;

    use HasApiTokens;

    public $table = 'users';

    protected $dates = ['deleted_at'];

    public $fillable = [
            'name',
            'email',
            'password'
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

}
