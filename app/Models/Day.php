<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Day
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Day whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Day whereName($value)
 * @mixin \Eloquent
 */
class Day extends Model
{
	const MONDAY    = 'Понедельник';
	const TUESDAY   = 'Вторник';
	const WEDNESDAY = 'Среда';
	const THURSDAY  = 'Четверг';
	const FRIDAY    = 'Пятница';
	const SATURDAY  = 'Суббота';
	const SUNDAY    = 'Воскресенье';

	/**
	 * @var array
	 */
	public static $items = [
		self::MONDAY,
		self::TUESDAY,
		self::WEDNESDAY,
		self::THURSDAY,
		self::FRIDAY,
		self::SATURDAY,
		self::SUNDAY,
	];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'days';

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
