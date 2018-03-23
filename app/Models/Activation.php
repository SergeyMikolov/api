<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Activation
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $ip_address
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activation whereUserId($value)
 * @mixin \Eloquent
 */
class Activation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activations';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'user_id',
        'token',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
