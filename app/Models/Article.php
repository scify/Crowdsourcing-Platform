<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_article_id', 'status_id', 'title', 'slug', 'body', 'excerpt', 'body_image', 'thumbnail_image',
        'last_edited_by_user_id', 'category_id', 'cms_id', 'is_sticky'
    ];

    public function actionsHistory() {
        return $this->hasMany(ArticleActionHistory::class, 'article_id', 'id');
    }

    public function editor() {
        return $this->belongsTo(User::class, 'last_edited_by_user_id', 'id');
    }

    public function childArticles() {
        return $this->hasMany(Article::class, 'parent_article_id', 'id');
    }

    public function collaborationRequests() {
        return $this->hasMany(CollaborationRequest::class, 'for_article_id', 'id');
    }

    public function status() {
        return $this->hasOne(ArticleStatus::class, 'id', 'status_id');
    }

    public function parent() {
        return $this->hasOne(Article::class, 'id', 'parent_article_id');
    }

    public function cms() {
        return $this->belongsTo(CMS::class, 'cms_id', 'id');
    }

    public function storeInfo() {
        return $this->hasMany(ArticleStoreInfo::class, 'article_id', 'id');
    }

    public function purchases() {
        return $this->hasMany(ArticlePurchase::class, 'article_id', 'id');
    }

    public function purchasedFromStore() {
        return $this->hasOne(ArticlePurchase::class, 'generated_article_id', 'id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'article_tags', 'article_id', 'tag_id')
            ->wherePivot('deleted_at', null);
    }

    public function articleTags() {
        return $this->hasMany(ArticleTag::class, 'article_id', 'id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'article_categories', 'article_id', 'category_id')
            ->wherePivot('deleted_at', null);
    }

    public function articleCategories() {
        return $this->hasMany(ArticleCategory::class, 'article_id', 'id');
    }
}
