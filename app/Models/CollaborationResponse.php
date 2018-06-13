<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollaborationResponse extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collaboration_responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'collaboration_request_id', 'user_id', 'body', 'status_id'
    ];

    public function collaborationRequest() {
        return $this->belongsTo(CollaborationRequest::class, 'collaboration_request_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status() {
        return $this->hasOne(CollaborationStatus::class, 'id', 'status_id');
    }

    public function media() {
        return $this->hasMany(CollaborationResponseMedia::class, 'collaboration_response_id', 'id');
    }
}
