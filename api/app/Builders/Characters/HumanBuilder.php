<?php

namespace App\Builders\Characters;

use App\Character;
use App\Equipment;

class HumanBuilder implements ICharacterBuilder
{
    private $character;
    private $equipment;

    public function __construct(Equipment $initialEquipment = null)
    {
        $this->equipment = $initialEquipment;

        $this->character = new Character;
        $this->character->setRawAttributes([
            'race' => 'human',
            'hit_points' => 12,
            'strength' => 1,
            'agility' => 2,
        ]);
    }

    public function build(Equipment $initialEquipment = null)
    {
        if ($initialEquipment) $this->equipment = $initialEquipment;

        if ($this->equipment) {
            $this->equipment->setAttribute('is_equipped', true);
            $this->character->equipment()->associate($this->equipment);
        }

        return $this->character;
    }
}
