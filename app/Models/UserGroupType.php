<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserGroupType
 *
 * @property int $user_id
 * @property int $group_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroupType whereGroupTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroupType whereUserId($value)
 * @mixin \Eloquent
 */
class UserGroupType extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_group_type';
}
