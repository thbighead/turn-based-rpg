<?php

namespace App;

use App\Services\Dice;
use Exception;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Character
 *
 * @package App
 *
 * @property string $race
 * @property int $hit_points
 * @property int $strength
 * @property int $agility
 * @property-read Equipment $equipment
 */
class Character extends Model
{
    private $d20;

    /**
     * Character constructor.
     * @param array $attributes
     * @throws Exception
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->d20 = new Dice(20);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'race',
        'hit_points',
        'strength',
        'agility',
    ];

    public function equipment()
    {
        return $this->embedsOne(Equipment::class);
    }

    public function rollAttackTest($additional_modifier = 0)
    {
        return $this->d20->roll() + $this->agility + $this->equipment->bonus_attack + $additional_modifier;
    }

    public function rollAttackDamage($additional_modifier = 0)
    {
        return $this->equipment->dice->roll() + $this->strength + $additional_modifier;
    }

    public function rollDefenseTest($additional_modifier = 0)
    {
        return $this->d20->roll() + $this->agility + $this->equipment->bonus_defense + $additional_modifier;
    }

    public function rollInitiative($additional_modifier = 0)
    {
        return $this->d20->roll() + $this->agility + $additional_modifier;
    }
}
