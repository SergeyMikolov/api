<?php

namespace App\Models\Instagram;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BotAccount
 *
 * @package App\Models
 * @property int                 $id
 * @property string              $name
 * @property string              $email
 * @property string              $password
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BotAccount whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|BotAccount whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|BotAccount whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|BotAccount whereEmail( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|BotAccount wherePassword( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|BotAccount whereUpdatedAt( $value )
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
		'email',
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
		'id',
	];
}