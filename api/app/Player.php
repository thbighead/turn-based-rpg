<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Jenssegers\Mongodb\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Class Player
 *
 * @package App
 *
 * @property string $nickname
 */
class Player extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function character()
    {
        return $this->embedsOne(Character::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
