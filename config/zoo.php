<?php

use Deerdama\ConsoleZoo\Zoo;

return [
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