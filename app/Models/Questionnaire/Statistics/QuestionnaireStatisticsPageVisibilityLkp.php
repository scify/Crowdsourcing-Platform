<?php

declare(strict_types=1);

namespace App\Models\Questionnaire\Statistics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\QuestionnaireStatisticsPageVisibilityLkp
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatisticsPageVisibilityLkp withoutTrashed()
 *
 * @mixin \Eloquent
 */
class QuestionnaireStatisticsPageVisibilityLkp extends Model {
    use SoftDeletes;

    protected $table = 'questionnaire_statistics_page_visibility_lkp';
}
