<?php

namespace App\Services;

use Exception;

class Dice
{
    private $number_of_faces;

    /**
     * Dice constructor.
     * @param int $number_of_faces
     * @throws Exception
     */
    public function __construct($number_of_faces)
    {
        if ($number_of_faces < 3)
            throw new Exception("'$number_of_faces' is not a valid number of dice faces.");

        $this->number_of_faces = $number_of_faces;
    }

    public function roll(): int
    {
        return rand(1, $this->number_of_faces);
    }
}
