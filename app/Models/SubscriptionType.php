<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubscriptionType
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $lessons_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscriptionType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscriptionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscriptionType whereLessonsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscriptionType whereName($value)
 */
class SubscriptionType extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'subscription_types';

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
		'lessons_count',
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
