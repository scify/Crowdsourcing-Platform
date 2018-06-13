<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleActionsLookup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_actions_lkp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
