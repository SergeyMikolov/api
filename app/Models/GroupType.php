<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GroupType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereName( $value )
 * @mixin \Eloquent
 * @property string $img
 * @property string $requirements
 * @property string $duration
 * @property bool $display
 * @property int $display_order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GroupType whereRequirements($value)
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
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'description',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id',
	];
}
