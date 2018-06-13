<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticlePurchase extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_purchases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id','cost', 'user_creator_id', 'payment_processed_for_creator', 'purchased_by_user_id', 'payment_processed_for_buyer',
        'generated_article_id', 'purchased_at'
    ];

    public function article() {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    public function userPurchased() {
        return $this->belongsTo(User::class, 'purchased_by_user_id', 'id');
    }

    public function generatedArticle() {
        return $this->belongsTo(Article::class, 'generated_article_id', 'id');
    }

}
