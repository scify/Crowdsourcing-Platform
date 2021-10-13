<?php

namespace App\Models\CrowdSourcingProject;

use App\Models\Language;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class CrowdSourcingProject
 * @package App\Models
 */
class CrowdSourcingProject extends Model {
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
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'external_url', 'motto_title', 'motto_subtitle', 'description',
        'about', 'footer', 'img_path',
        'logo_path', 'user_creator_id', 'language_id', 'status_id', 'sm_title',
        'sm_description', 'sm_keywords', 'sm_featured_img_path', 'lp_motto_color',
        'lp_about_bg_color', 'lp_about_color', 'lp_questionnaire_img_path',
        'lp_questionnaire_color', 'lp_footer_bg_color', 'lp_footer_color',
        'lp_questionnaire_btn_color', 'lp_questionnaire_btn_bg_color',
        'lp_questionnaire_goal_title_color', 'lp_questionnaire_goal_color',
        'lp_questionnaire_goal_bg_color',
        'lp_newsletter_title_color', 'lp_newsletter_color',
        'lp_newsletter_bg_color', 'lp_newsletter_btn_color',
        'lp_newsletter_btn_bg_color', 'communication_resources_id',
        'lp_show_speak_up_btn', 'lp_motto_overlay_color',
        'lp_external_url_btn_color', 'lp_about_img_path', 'lp_motto_inner_bg_color'
    ];

    /**
     * @return BelongsTo
     */
    public function creator() {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }


    /**
     * The users that belong to the role.
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
    public function status() {
        return $this->hasOne(CrowdSourcingProjectStatusLkp::class, 'id', 'status_id');
    }

    /**
     * @return HasOne
     */
    public function communicationResources() {
        return $this->hasOne(CrowdSourcingProjectCommunicationResources::class, 'id', 'communication_resources_id');
    }

    /**
     * @return HasMany
     */
    public function colors() {
        return $this->hasMany(CrowdSourcingProjectColors::class, 'project_id', 'id');
    }
}
