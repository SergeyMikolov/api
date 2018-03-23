<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Group
 *
 * @property int $id
 * @property int $group_type_id
 * @property int $trainer_id
 * @property int $day_id
 * @property string $training_time
 * @property int $capacity
 * @property int $max_capacity
 * @property bool $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereGroupTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereMaxCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereTrainerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Group whereTrainingTime($value)
 * @mixin \Eloquent
 */
class Group extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';

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
		'type_id',
		'trainer_id',
		'day_id',
		'time',
		'capacity',
		'max_capacity',
		'is_active',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id'
	];
}
