<?php

namespace App\Builders\Equipments;

use App\Equipment;

class LongSwordBuilder extends EquipmentBuilder
{
    public function __construct()
    {
        $this->equipment = new Equipment;
        $this->equipment->setRawAttributes([
            'name' => 'Espada Longa',
            'bonus_attack' => 2,
            'bonus_defense' => 1,
            'dice_faces' => 6,
            'is_equipped' => false,
        ]);
    }
}
