<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Category extends Model
{
    use HasFactory, HasApiTokens;

    public $table = 'categories';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    public static $rules = [
        'name' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news() {
        return $this->hasMany(News::class, 'user_id');
    }

}
