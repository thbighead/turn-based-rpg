<?php

namespace App\Builders\Equipments;

use App\Equipment;
use Illuminate\Support\Arr;

class WoodClubBuilder implements EquipmentBuilder
{
    private $equipment;

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
