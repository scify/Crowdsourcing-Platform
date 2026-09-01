<?php

declare(strict_types=1);

namespace App\Models\CrowdSourcingProject;

use App\Models\Language;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\CrowdSourcingProjectTranslation
 *
 * @property int $language_id
 * @property int $project_id
 * @property string $name
 * @property string $motto_title
 * @property string $motto_subtitle
 * @property string $description
 * @property string $about
 * @property string $footer
 * @property string $sm_title
 * @property string $sm_description
 * @property string $sm_keywords
 * @property string $questionnaire_response_email_intro_text
 * @property string $questionnaire_response_email_outro_text
 * @property string $banner_title
 * @property string $banner_text
 * @property string $thank_you_message
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Language|null $language
 * @property-read CrowdSourcingProject|null $project
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereBannerText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereBannerTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereMottoSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereMottoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereQuestionnaireResponseEmailIntroText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereQuestionnaireResponseEmailOutroText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereSmDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereSmKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereSmTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereThankYouMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectTranslation withoutTrashed()
 *
 * @mixin \Eloquent
 */
class CrowdSourcingProjectTranslation extends Model {
    use Compoships;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crowd_sourcing_project_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'language_id', 'project_id', 'name', 'motto_title', 'motto_subtitle', 'description',
        'about', 'footer', 'sm_title', 'sm_description', 'sm_keywords',
        'questionnaire_response_email_intro_text', 'questionnaire_response_email_outro_text',
        'banner_title', 'banner_text', 'thank_you_message',
    ];

    public function project(): BelongsTo {
        return $this->belongsTo(CrowdSourcingProject::class, 'project_id', 'id');
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    protected static function boot() {
        parent::boot();

        // Trim all string attributes before saving
        static::saving(function ($model): void {
            $model->trimAttributes();
        });
    }

    /**
     * Trim all string attributes
     */
    protected function trimAttributes() {
        foreach ($this->attributes as $key => $value) {
            if (is_string($value) && $value !== '') {
                $this->attributes[$key] = trim($value);
            }
        }
    }
}
