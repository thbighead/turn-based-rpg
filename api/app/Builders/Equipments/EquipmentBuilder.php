<?php

namespace App\Builders\Equipments;

use Illuminate\Support\Arr;

abstract class EquipmentBuilder implements IEquipmentBuilder
{
    protected $equipment;

    public function build(array $customized_bonus = [])
    {
        $customized_bonus = Arr::only($customized_bonus, [
            'name',
            'bonus_attack',
            'bonus_defense',
            'dice_faces',
        ]);
        $this->equipment->setRawAttributes([
            'name' => Arr::get($customized_bonus, 'name', $this->equipment->name),
            'bonus_attack' => Arr::get($customized_bonus, 'bonus_attack', $this->equipment->bonus_attack),
            'bonus_defense' => Arr::get($customized_bonus, 'bonus_defense', $this->equipment->bonus_defense),
            'dice_faces' => Arr::get($customized_bonus, 'dice_faces', $this->equipment->dice_faces),
        ]);

        return $this->equipment;
    }
}
