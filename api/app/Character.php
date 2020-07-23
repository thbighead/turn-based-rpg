<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Character extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'race',
        'hit_points',
        'strength',
        'defense',
        'agility',
    ];

    public function equipment()
    {
        return $this->embedsOne(Equipment::class);
    }
}
