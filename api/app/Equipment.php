<?php

namespace App;

use App\Services\Dice;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Equipment
 *
 * @package App
 *
 * @property string $name
 * @property int $bonus_attack
 * @property int $bonus_defense
 * @property int $dice_faces
 * @property bool $is_equipped
 */
class Equipment extends Model
{
    public $dice;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->dice = new Dice($this->dice_faces);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'bonus_attack',
        'bonus_defense',
        'dice_faces',
        'is_equipped',
    ];
}
