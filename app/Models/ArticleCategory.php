<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'category_id'
    ];

    // THIS IS A BUG!!! DO NOT USE THEM IN NEWSCENTRAL AS IT WILL DISPLAY ALL ARTICLES AVAILABLE IN STORE AS NEWSCENTRAL ARTICLES!!
//    public function articles() {
//        return $this->hasMany(Article::class, 'article_id', 'id');
//    }

//    public function categories() {
//        return $this->hasMany(Category::class, 'category_id', 'id');
//    }
}
