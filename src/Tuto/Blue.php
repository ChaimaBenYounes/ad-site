<?php

namespace App\Tuto;

use App\Tuto\ColorInterface;

class Blue implements ColorInterface
{
    static function getColor()
    {
        return 'blue';
    }
}