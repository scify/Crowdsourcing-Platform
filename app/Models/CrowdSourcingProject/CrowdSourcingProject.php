<?php

namespace App\Models\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\Language;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CrowdSourcingProject
 *
 * @property int $id
 * @property string $slug
 * @property string $external_url
 * @property string $img_path
 * @property string $logo_path
 * @property int $user_creator_id
 * @property int $language_id
 * @property int $status_id
 * @property string $sm_featured_img_path
 * @property string $lp_questionnaire_img_path
 * @property int $lp_show_speak_up_btn
 * @property string $lp_primary_color
 * @property string $lp_btn_text_color_theme
 * @property int $should_send_email_after_questionnaire_response
 * @property int $display_landing_page_banner
 */
class CrowdSourcingProject extends Model {
    use Compoships;
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crowd_sourcing_projects';

    /**
     * The attributes that are mass assignable.
     *
     * Note: in the lp_* fields, lp stands for landing page
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'external_url', 'img_path',
        'logo_path', 'user_creator_id', 'language_id', 'status_id',
        'sm_featured_img_path', 'lp_questionnaire_img_path',
        'lp_show_speak_up_btn', 'lp_primary_color', 'lp_btn_text_color_theme',
        'should_send_email_after_questionnaire_response',
        'display_landing_page_banner',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['defaultTranslation'];

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    /**
     * The users that belong to the role.
     */
    public function questionnaires(): BelongsToMany {
        return $this->belongsToMany(
            Questionnaire::class,
            'crowd_sourcing_project_questionnaires',
            'project_id',
            'questionnaire_id')
            ->orderBy('questionnaires.created_at');
    }

    public function language(): HasOne {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function defaultTranslation(): HasOne {
        return $this->hasOne(CrowdSourcingProjectTranslation::class,
            ['project_id', 'language_id'], ['id', 'language_id'])->withDefault([
                'questionnaire_response_email_intro_text' => __('email_messages.thanks_message_for_contribution'),
                'questionnaire_response_email_outro_text' => __('email_messages.inquiries_about_our_work'),
            ]);
    }

    public function translations(): HasMany {
        return $this->hasMany(CrowdSourcingProjectTranslation::class, 'project_id', 'id');
    }

    public function languages(): HasManyThrough {
        return $this->hasManyThrough(Language::class,
            CrowdSourcingProjectTranslation::class,
            'project_id',
            'id',
            'id',
            'language_id'
        );
    }

    public function status(): HasOne {
        return $this->hasOne(CrowdSourcingProjectStatusLkp::class, 'id', 'status_id');
    }

    public function colors(): HasMany {
        return $this->hasMany(CrowdSourcingProjectColors::class, 'project_id', 'id');
    }

    public function problems(): HasMany {
        return $this->hasMany(CrowdSourcingProjectProblem::class, 'project_id', 'id');
    }
}
