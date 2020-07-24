<?php

namespace App\Builders\Equipments;

use App\Equipment;
use Illuminate\Support\Arr;

class WoodClubBuilder extends EquipmentBuilder
{
    public function __construct()
    {
        $this->equipment = new Equipment;
        $this->equipment->setRawAttributes([
            'name' => 'Clava de Madeira',
            'bonus_attack' => 1,
            'bonus_defense' => 0,
            'dice_faces' => 8,
            'is_equipped' => false,
        ]);
    }
}
