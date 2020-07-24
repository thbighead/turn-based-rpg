<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Game
 *
 * @package App
 *
 * @property string $log
 * @property-read Battle $battle
 * @property-read Player $player
 */
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

    public function appendBattleLog($battleLog)
    {
        $this->log .= "\n\n$battleLog";
        $this->save();
    }

    public function over()
    {
        return $this->battle->finished;
    }
}
