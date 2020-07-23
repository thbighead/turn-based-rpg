<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Equipment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bonus_attack',
        'bonus_defense',
        'dice_faces',
        'is_equipped',
    ];
}
