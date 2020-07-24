<?php

namespace App\Services;

class Dice
{
    private $number_of_faces;

    public function __construct($number_of_faces)
    {
        $this->number_of_faces = $number_of_faces;
    }

    public function roll(): int
    {
        return rand(1, $this->number_of_faces);
    }
}
