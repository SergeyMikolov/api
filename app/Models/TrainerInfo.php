<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Trainer
 *
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $description
 * @property string $img
 * @property bool $display
 * @property int $display_order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrainerInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrainerInfo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrainerInfo whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrainerInfo whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrainerInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrainerInfo whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrainerInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TrainerInfo whereUserId($value)
 * @mixin \Eloquent
 */
class TrainerInfo extends Model
{
	const IMG_FOLDER = 'trainers/';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'trainers_info';

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
		'description',
		'display',
		'display_order',
		'img',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'id',
	];

	/**
	 * @return string
	 */
	public function getRealImagePath() : string
	{
		return \Storage::disk('images')->path($this->img);
	}

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['img_url'];

	/**
	 * @return string
	 */
	public function getImgUrlAttribute() : string
	{
		return $this->getImageUrl();
	}

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public function getImageUrl()
	{
		return imgUrl($this->img);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() : BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
