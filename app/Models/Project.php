<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'motto', 'label1', 'label2', 'description', 'img_path', 'user_creator_id'
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }
}
