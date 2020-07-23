<?php

namespace App\Builders\Characters;

use App\Character;
use App\Equipment;

class OrcBuilder implements CharacterBuilder
{
    private $character;
    private $equipment;

    public function __construct(Equipment $initialEquipment = null)
    {
        $this->equipment = $initialEquipment;
        $this->character = new Character;
        $this->character->setRawAttributes([
            'race' => 'orc',
            'hit_points' => 20,
            'strength' => 2,
            'agility' => 0,
        ]);
    }

    public function build(Equipment $initialEquipment = null)
    {
        if ($initialEquipment) $this->equipment = $initialEquipment;

        if ($this->equipment) {
            $this->equipment->setAttribute('is_equipped', true);
            $this->character->equipment()->save($this->equipment);
        }

        return $this->character;
    }
}
