<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GroupType
 *
 * @property int $id
 * @property string $slug
 * @property string $description
 * @property string $img
 * @property string|null $requirements
 * @property string|null $duration
 * @property bool $display
 * @property int|null $display_order
 * @property string $display_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereSlug($value)
 * @mixin \Eloquent
 */
class GroupType extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'group_types';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'slug',
		'description',
		'display',
		'display_name',
		'display_order',
		'img',
		'requirements',
		'duration',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id',
	];

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['img_url'];

	/**
	 * @return string
	 */
	public function getImgUrlAttribute()
	{
		return $this->getImageUrl();
	}

	/**
	 * @return string
	 */
	public function getRouteKeyName()
	{
		return 'slug';
	}

	/**
	 * @return string
	 */
	public function getRealImagePath()
	{
		return \Storage::disk('images')->path($this->img);
	}

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public function getImageUrl()
	{
		return imgUrl($this->img);
	}
}
