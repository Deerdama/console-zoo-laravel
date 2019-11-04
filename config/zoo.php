<?php

use Deerdama\ConsoleZoo\Zoo;

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
        'icons' => Zoo::TURTLE,
        'color' => Zoo::COLOR_BLUE,
        'bold'
    ],

    'defaults_success' => [
        'icons' => Zoo::SQUIRREL,
        'color' => Zoo::COLOR_GREEN
    ],

    'defaults_warning' => [
        'icons' => Zoo::PIG,
        'color' => Zoo::COLOR_ORANGE
    ],

    'defaults_error' => [
        'icons' => Zoo::WEARY_CAT_FACE,
        'color' => Zoo::COLOR_RED,
        'bold'
    ]
];