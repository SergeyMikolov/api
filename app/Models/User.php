<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string $password
 * @property string|null $remember_token
 * @property bool $activated
 * @property string $token
 * @property string|null $signup_ip_address
 * @property string|null $signup_confirmation_ip_address
 * @property string|null $signup_sm_ip_address
 * @property string|null $admin_ip_address
 * @property string|null $updated_ip_address
 * @property string|null $deleted_ip_address
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profiles
 * @property-read \Illuminate\Database\Eloquent\Collection|\jeremykenedy\LaravelRoles\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Social[] $social
 * @property-read \Illuminate\Database\Eloquent\Collection|\jeremykenedy\LaravelRoles\Models\Permission[] $userPermissions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAdminIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSignupConfirmationIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSignupIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSignupSmIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GroupType[] $groupTypes
 * @property-read \App\Models\TrainerInfo $trainerInfo
 */
class User extends Authenticatable
{
    use HasRoleAndPermission;
    use Notifiable;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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
        'first_name',
        'last_name',
        'email',
        'password',
        'activated',
        'token',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'signup_sm_ip_address',
        'admin_ip_address',
        'updated_ip_address',
        'deleted_ip_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activated',
        'token',
    ];

	/**
	 * @var array
	 */
	protected $dates = [
        'deleted_at',
    ];

	/**
	 * Build Social Relationships.
	 *
	 * @var array
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function social() : HasMany
	{
        return $this->hasMany(Social::class);
    }

	/**
	 * User Profile Relationships.
	 *
	 * @var array
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
    public function profile() : HasOne
	{
        return $this->hasOne(Profile::class);
    }

    // User Profile Setup - Should move these to a trait or interface...

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function profiles() : BelongsToMany
	{
        return $this->belongsToMany(Profile::class)->withTimestamps();
    }

	/**
	 * @param $name
	 * @return bool
	 */
	public function hasProfile($name) : bool
	{
        foreach ($this->profiles as $profile) {
            if ($profile->name === $name) {
                return true;
            }
        }

        return false;
    }

	/**
	 * @param $profile
	 */
	public function assignProfile($profile)
    {
        return $this->profiles()->attach($profile);
    }

	/**
	 * @param $profile
	 * @return int
	 */
	public function removeProfile($profile) : int
	{
        return $this->profiles()->detach($profile);
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function groupTypes () : BelongsToMany
	{
		return $this->belongsToMany(GroupType::class, 'user_group_type',
			'user_id', 'group_type_id');
	}

	/**
	 * @return HasOne
	 */
	public function trainerInfo() : HasOne
	{
		return $this->hasOne(TrainerInfo::class);
	}
}
