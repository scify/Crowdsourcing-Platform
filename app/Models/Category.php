<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'cms_id', 'user_creator_id'
    ];

    public function cms() {
        return $this->belongsTo(CMS::class, 'cms_id', 'id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    public function articles() {
        return $this->belongsToMany(Article::class, 'article_categories', 'category_id', 'article_id')
            ->wherePivot('deleted_at', null);
    }
}
