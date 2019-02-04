<?php

namespace App\Tuto;

/**
 * A class that contains all colors services
 *
 * Class ColorContainer
 */
class ColorContainer
{
    protected $colors = [];

    public function __construct()
    {
    }

    public function displayColor()
    {
        return '<p style="background-color: '. $this->color .'">HAHAHAHAHAHAH</p>';
    }

    /**
     * A function that add a color to the array.
     *
     * @param $color
     */
    public function addColor($color)
    {
        $this->colors[] = $color;
    }

    public function getColors()
    {
        return $this->colors;
    }
}