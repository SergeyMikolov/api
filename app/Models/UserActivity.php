<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserActivity
 *
 * @property int $id
 * @property int $user_id
 * @property int $group_id
 * @property int $trainer_id
 * @property bool $is_present
 * @property int $creator_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserActivity whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserActivity whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserActivity whereIsPresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserActivity whereTrainerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserActivity whereUserId($value)
 * @mixin \Eloquent
 */
class UserActivity extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users_activity';

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
		'group_id',
		'trainer_id',
		'is_present',
		'creator_id',
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
