<?php

namespace App\Builders\Characters;

use App\Equipment;

interface CharacterBuilder
{
    public function build(Equipment $initialEquipment = null);
}
