<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BotAccount
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $password
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotAccount wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BotAccount extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bot_accounts';

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
		'password',
		'created_at',
		'updated_at',
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
