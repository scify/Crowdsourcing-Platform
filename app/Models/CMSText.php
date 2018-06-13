<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CMSText extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_texts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cms_id', 'legal_terms', 'privacy_policy', 'created_at', 'updated_at'
    ];

    public function cms()
    {
        return $this->belongsTo(CMS::class, 'cms_id', 'id');
    }
}
