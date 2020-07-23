<?php

namespace App\Repository;

use App\Battle;
use App\Builders\Characters\OrcBuilder;
use App\Builders\Equipments\WoodClubBuilder;
use App\Game;

class BattleRepository
{
    private $enemyBuilder;

    public function __construct()
    {
        $this->enemyBuilder = new OrcBuilder((new WoodClubBuilder())->build());
    }

    public function createGameBattle(Game $game)
    {
        $battle = new Battle;
        $enemy = $this->enemyBuilder->build();
        $battle->character()->associate($enemy);
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
        $battle->save();
        $game->battle()->associate($battle);

        return $battle;
    }
}
