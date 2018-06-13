<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollaborationResponseMedia extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collaboration_response_media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id', 'collaboration_response_id', 'file_path'
    ];

    public function collaborationResponse() {
        return $this->belongsTo(CollaborationResponse::class, 'collaboration_response_id', 'id');
    }

    public function status() {
        return $this->hasOne(CollaborationResponseMediaType::class, 'id', 'type_id');
    }
}
