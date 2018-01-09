<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Social
 *
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $social_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Social whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Social whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Social whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Social whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Social whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Social whereUserId($value)
 * @mixin \Eloquent
 */
class Social extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'social_logins';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
