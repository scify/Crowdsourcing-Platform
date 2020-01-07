<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CrowdSourcingProject
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $motto
 * @property string $description
 * @property string $about
 * @property string $footer
 * @property string $img_path
 * @property string $logo_path
 * @property int $user_creator_id
 * @property int $language_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Questionnaire[] $questionnaires
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CrowdSourcingProject onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereImgPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereMotto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdSourcingProject whereUserCreatorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CrowdSourcingProject withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CrowdSourcingProject withoutTrashed()
 * @mixin \Eloquent
 */
class CrowdSourcingProject extends Model
{
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
        'name', 'slug', 'motto', 'description', 'about',  'footer', 'img_path',
        'logo_path', 'user_creator_id', 'language_id', 'status_id', 'sm_title', 'sm_description',
        'sm_featured_img_path'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, 'project_id', 'id');
    }

    public function language() {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function status() {
        return $this->hasOne(CrowdSourcingProjectStatusLkp::class, 'id', 'status_id');
    }
}
