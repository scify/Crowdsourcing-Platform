<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CMSSocialMedia extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_social_media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cms_id', 'facebook', 'twitter', 'youtube', 'google_plus', 'created_at', 'updated_at'
    ];

    public function cms()
    {
        return $this->belongsTo(CMS::class, 'cms_id', 'id');
    }
}
