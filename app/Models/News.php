<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    public $table = 'news';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @var string[]
     */
    public $fillable = [
        'title',
        'short_description',
        'description',
        'isVisible',
        'image_url',
        'category_id',
        'user_id'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'short_description' => 'string',
        'description' => 'string',
        'isVisible' => 'boolean',
        'image_url' => 'string',
        'category_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * @var string[]
     */
    public static $rules = [
        'title' => 'required',
        'short_description' => 'required',
        'description' => 'required',
        'isVisible' => 'required',
        'image_url' => 'required',
        'category_id' => 'required',
        'user_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userId() {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryId() {
        return $this->belongsTo(Category::class,'category_id');
    }
}
