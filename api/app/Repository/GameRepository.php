<?php

namespace App\Repository;

use App\Game;
use App\Player;

class GameRepository
{
    public function createPlayerGame(Player $player)
    {
        $game = new Game;
        $game->player()->associate($player);
        $game->save();

        return $game;
    }

    public function find($id)
    {
        $game = new Game;

        return $game->find($id);
    }
}
