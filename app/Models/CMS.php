<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CMS extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'system_name', 'logo_path'
    ];

    public function getRouteKeyName()
    {
        return 'system_name';
    }

    public function cmsTexts()
    {
        return $this->hasOne(CMSText::class, 'cms_id', 'id');
    }

    public function socialMedia()
    {
        return $this->hasOne(CMSSocialMedia::class, 'cms_id', 'id');
    }
}
