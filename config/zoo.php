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
    | eg: changing the content of 'defaults_info' will change the style
    | when calling the $this->zooInfo() method.
    | All current parameters can be changed, and any other available param can be added
    |
    */

    'defaults_info' => [
        'icons' => Icon::TURTLE,
        'color' => Color::BLUE,
        'bold'
    ],

    'defaults_success' => [
        'icons' => Icon::SQUIRREL,
        'color' => Color::GREEN,
        'bold'

    ],

    'defaults_warning' => [
        'icons' => Icon::PIG,
        'color' => Color::ORANGE,
        'bold'

    ],

    'defaults_error' => [
        'icons' => Icon::WEARY_CAT_FACE,
        'color' => Color::RED,
        'bold'
    ]
];