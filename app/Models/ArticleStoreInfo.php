<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleStoreInfo extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_store_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'teaser', 'category_id', 'teaser_image_path', 'cost', 'status_id'
    ];

    public function article() {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function status() {
        return $this->hasOne(ArticleStatus::class, 'id', 'status_id');
    }

    public function articlePurchases() {
        return $this->hasMany(ArticlePurchase::class, 'article_id', 'article_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
