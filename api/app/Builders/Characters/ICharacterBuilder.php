<?php

namespace App\Builders\Characters;

use App\Equipment;

interface ICharacterBuilder
{
    public function build(Equipment $initialEquipment = null);
}
