<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleTag extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'tag_id'
    ];

    public function article() {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function tag() {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
