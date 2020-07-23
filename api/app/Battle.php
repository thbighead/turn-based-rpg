<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Battle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'finished',
        'turn',
        'initiatives',
        'damages',
    ];

    public function character()
    {
        return $this->embedsOne(Character::class);
    }
}
