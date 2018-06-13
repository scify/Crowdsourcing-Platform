<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollaborationRequest extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collaboration_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_user_id', 'for_article_id', 'task_description', 'status_id'
    ];

    public function article() {
        return $this->belongsTo(Article::class, 'for_article_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function status() {
        return $this->hasOne(CollaborationStatus::class, 'id', 'status_id');
    }

    public function collaborationResponses() {
        return $this->hasMany(CollaborationResponse::class);
    }
}
