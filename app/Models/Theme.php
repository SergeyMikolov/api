<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Theme
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string|null $notes
 * @property bool $status
 * @property int $taggable_id
 * @property string $taggable_type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profile
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Theme onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereTaggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereTaggableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Theme whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Theme withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Theme withoutTrashed()
 * @mixin \Eloquent
 */
class Theme extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'themes';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'notes',
        'status',
        'taggable_id',
        'taggable_type',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return array
     */
    public static function rules($id = 0, $merge = [])
    {
        return array_merge(
            [
                'name'   => 'required|min:3|max:50|unique:themes,name'.($id ? ",$id" : ''),
                'link'   => 'required|min:3|max:255|unique:themes,link'.($id ? ",$id" : ''),
                'notes'  => 'max:500',
                'status' => 'required',
            ],
            $merge);
    }

    /**
     * Build Theme Relationships.
     *
     * @var array
     */
    public function profile()
    {
        return $this->hasMany('App\Models\Profile');
    }
}
