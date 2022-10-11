<?php

namespace App\Models\CrowdSourcingProject;

use App\Models\Language;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CrowdSourcingProject
 */
class CrowdSourcingProject extends Model {
    use SoftDeletes;
    use Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crowd_sourcing_projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'external_url', 'img_path',
        'logo_path', 'user_creator_id', 'language_id', 'status_id',
        'sm_featured_img_path', 'lp_questionnaire_img_path',
        'lp_show_speak_up_btn', 'lp_primary_color',
        'should_send_email_after_questionnaire_response',
        'display_landing_page_banner',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['defaultTranslation'];

    /**
     * @return BelongsTo
     */
    public function creator() {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    /**
     * The users that belong to the role.
     *
     * @return BelongsToMany
     */
    public function questionnaires() {
        return $this->belongsToMany(
            Questionnaire::class,
            'crowd_sourcing_project_questionnaires',
            'project_id',
            'questionnaire_id');
    }

    /**
     * @return HasOne
     */
    public function language() {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    /**
     * @return HasOne
     */
    public function defaultTranslation() {
        return $this->hasOne(CrowdSourcingProjectTranslation::class,
            ['project_id', 'language_id'], ['id', 'language_id'])->withDefault([
                'questionnaire_response_email_intro_text' => __('email_messages.thanks_message_for_contribution'),
                'questionnaire_response_email_outro_text' => __('email_messages.inquiries_about_our_work'),
            ]);
    }

    /**
     * @return HasMany
     */
    public function translations() {
        return $this->hasMany(CrowdSourcingProjectTranslation::class, 'project_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function status() {
        return $this->hasOne(CrowdSourcingProjectStatusLkp::class, 'id', 'status_id');
    }

    /**
     * @return HasMany
     */
    public function colors() {
        return $this->hasMany(CrowdSourcingProjectColors::class, 'project_id', 'id');
    }
}
