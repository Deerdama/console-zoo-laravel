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
    ],

    /*
    |--------------------------------------------------------------------------
    | Timestamps
    |--------------------------------------------------------------------------
    */

    /* whether a timestamp should be added in front of each output */
    'timestamp' => false,

    /* default timestamp format, timezone and style */
    'time' => [
        'tz' => config('app.timezone') ?? 'UTC',
        'format' => '[Y-m-d H:i:s]',
        'color' => Color::YELLOW_LIGHT_1,
        'bold' => false,
        'italic' => false,
        'icons' => false
    ],

    /* default format and style of the $this->>duration(); output */
    'duration' => [
        'format' => '%hh %im %ss',
        'color' => Color::GREEN_BRIGHT_3,
        'icons' => Icon::HOURGLASS_WITH_FLOWING_SAND,
        'timestamp' => false,
        'bold' => false,
        'italic' => false,
        'swap' => false
    ],

    /**
     * default format and style of the $this->>lap(); output
     *
     * 'prepend_text/append_text' = will prepend/append a specific text.
     * To include the current lap number use {lap_number} (brackets included)
     * eg: 'prepend_text' => 'Lap {lap_number} duration: '
     */
    'lap_duration' => [
        'format' => '%hh %im %ss',
        'color' => Color::TEAL_BRIGHT_2,
        'icons' => Icon::WATCH,
        'timestamp' => false,
        'bold' => false,
        'italic' => false,
        'swap' => false,
        'prepend_text' => false,
        'append_text' => false
    ]
];