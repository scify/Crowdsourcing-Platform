<?php

namespace App\Models\Solution;

use App\Models\CompositeKeysModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolutionTranslation extends CompositeKeysModel {
    use HasFactory;

    protected $table = 'solution_translations';
    protected $fillable = ['solution_id', 'language_id', 'title', 'description'];
    protected $primaryKey = ['solution_id', 'language_id'];
    public $incrementing = false;
}
