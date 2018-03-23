<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subscription
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $subscription_type_id
 * @property int $group_type_id
 * @property int $price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereGroupTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereSubscriptionTypeId($value)
 */
class Subscription extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'subscriptions';

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
		'user_id',
		'subscription_id',
		'creator_id',
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
