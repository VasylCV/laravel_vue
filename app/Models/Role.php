<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Role
 * @package App\Models
 * @version August 25, 2022, 7:31 am UTC
 *
 */
class Role extends Model
{
    use SoftDeletes;

    use HasFactory;

    const User = 1;
    const Admin = 2;

    public $table = 'roles';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|min:3',
    ];

    public static function getRoles()
    {
        return self::get()->pluck('title','id')->toArray();
    }

    public static function getRoleTitle($id)
    {
        return self::getRoles()[$id];
    }
}
