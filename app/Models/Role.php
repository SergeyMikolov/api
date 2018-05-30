<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


/**
 * Class Role
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $level
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\jeremykenedy\LaravelRoles\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role isAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role isTrainer()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends \jeremykenedy\LaravelRoles\Models\Role
{
	const ADMIN = 'admin';
	const TRAINER = 'trainer';

	/**
	 * @param Builder $query
	 * @return mixed
	 */
	public function scopeIsAdmin(Builder $query)
	{
		return $query->whereSlug(self::ADMIN);
	}

	/**
	 * @param Builder $query
	 * @return mixed
	 */
	public function scopeIsTrainer(Builder $query)
	{
		return $query->where('slug', self::TRAINER);
	}
}