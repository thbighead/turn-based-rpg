<?php

namespace App\Repository;

use App\Builders\Characters\HumanBuilder;
use App\Builders\Characters\OrcBuilder;
use App\Builders\Equipments\LongSwordBuilder;
use App\Builders\Equipments\WoodClubBuilder;

class CharacterRepository
{
    public function createHumanWithLongSword()
    {
        $longSword = (new LongSwordBuilder)->build();
        $longSword->save();
        $human = (new HumanBuilder($longSword))->build();
        $human->save();

        return $human;
    }

    public function createOrcWithWoodClub()
    {
        $woodClub = (new WoodClubBuilder())->build();
        $woodClub->save();
        $orc = (new OrcBuilder($woodClub))->build();
        $orc->save();

        return $orc;
    }
}
