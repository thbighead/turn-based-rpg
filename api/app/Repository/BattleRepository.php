<?php

namespace App\Repository;

use App\Battle;
use App\Game;

class BattleRepository
{
    private $characterRepository;

    public function __construct()
    {
        $this->characterRepository = new CharacterRepository();
    }

    public function createGameBattle(Game $game)
    {
        $battle = new Battle;
        $battle->setRawAttributes([
            'finished' => false,
            'turn' => 0,
            'initiatives' => [
                'player' => null,
                'enemy' => null,
            ],
            'damages' => [
                'player' => null,
                'enemy' => null,
            ],
        ]);
        $character = $this->characterRepository->createHumanWithLongSword();
        $enemy = $this->characterRepository->createOrcWithWoodClub();
        $battle->character()->associate($enemy);
        $battle->save();
        $game->battle()->associate($battle);
        $player = $game->player;
        $player->character()->associate($character);
        $player->save();
        $game->player()->associate($player);
        $game->log = "A WILD ORC APPEARS!\nOrc:\"Brace yourself, human, I'm smashing you into peaces!\"\nDefeat the Orc or pay with your life!";
        $game->save();

        return $battle;
    }
}
