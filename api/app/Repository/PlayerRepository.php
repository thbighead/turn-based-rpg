<?php

namespace App\Repository;

use App\Player;

class PlayerRepository
{
    public function findOrCreateByNickname($nickname)
    {
        $player = new Player;

        if ($playerFound = $player->where('nickname', $nickname)->first()) {
            return $playerFound;
        }

        $player->nickname = $nickname;
        $player->save();

        return $player;
    }
}
