<?php

use Deerdama\ConsoleZoo\Icon;
use Deerdama\ConsoleZoo\Color;

return [

    /*
    |--------------------------------------------------------------------------
    | Default outputs styles
    |--------------------------------------------------------------------------
    |
    | Changing the defaults will affect the respective output method.
    | eg: changing the content of 'info' will change the style
    | when calling the $this->zooInfo() method.
    | All current parameters can be changed, and any other available param can be added
    | https://github.com/Deerdama/console-zoo#Available-Parameters
    |
    */

    'info' => [
        'icons' => Icon::TURTLE,
        'color' => Color::BLUE,
        'bold'
    ],

    'success' => [
        'icons' => Icon::SQUIRREL,
        'color' => Color::GREEN,
        'bold'

    ],

    'warning' => [
        'icons' => Icon::PIG,
        'color' => Color::ORANGE,
        'bold'

    ],

    'error' => [
        'icons' => Icon::WEARY_CAT_FACE,
        'color' => Color::RED,
        'bold'
    ]
];