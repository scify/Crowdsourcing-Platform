<?php

namespace App\Models;

use App\ArticleActionsLookup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleActionHistory extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_action_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'action_id', 'user_id', 'description'
    ];

    public function article() {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function action() {
        return $this->belongsTo(ArticleActionsLookup::class, 'action_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
