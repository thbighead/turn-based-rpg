<?php

namespace App\Builders\Equipments;

use App\Equipment;
use Illuminate\Support\Arr;

class LongSwordBuilder implements EquipmentBuilder
{
    private $equipment;

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

    public function build(array $customized_bonus = [])
    {
        $this->equipment->setRawAttributes(Arr::only($customized_bonus, [
            'name',
            'bonus_attack',
            'bonus_defense',
            'dice_faces',
        ]));

        return $this->equipment;
    }
}
