<?php

namespace App\Models\CrowdSourcingProject;

use App\Models\Language;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrowdSourcingProjectTranslation extends Model {
    use SoftDeletes;
    use Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crowd_sourcing_project_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'project_id', 'name', 'motto_title', 'motto_subtitle', 'description',
        'about', 'footer', 'sm_title', 'sm_description', 'sm_keywords',
        'questionnaire_response_email_intro_text', 'questionnaire_response_email_outro_text',
        'banner_title', 'banner_text',
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo {
        return $this->belongsTo(CrowdSourcingProject::class, 'project_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
