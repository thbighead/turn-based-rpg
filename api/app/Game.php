<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Game extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    public function player()
    {
        return $this->embedsOne(Player::class);
    }

    public function battle()
    {
        return $this->embedsOne(Battle::class);
    }
}
