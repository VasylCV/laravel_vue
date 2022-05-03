<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Article
 * @package App\Models
 * @version April 19, 2022, 1:13 pm UTC
 *
 */
class Article extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'articles';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'text',
        'author_id'
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
        'title' => 'required|string|min:8 '
    ];

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

}
