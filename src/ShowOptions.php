<?php

namespace Deerdama\ConsoleZoo;

use Illuminate\Console\Command;
use ReflectionClass;

class ShowOptions extends Command
{
    use ConsoleZoo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoo:options';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all available icons and colors and their respective names/keys';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->zooOptions = new ReflectionClass(Zoo::class);
        $this->zooOptions = $this->zooOptions->getConstants();

        $this->zooSetDefaults([
            'background' => 'blue',
            'bold',
            'italic'
        ]);

        $this->show = $this->choice('Show me....', [
            'everything', 'available icons', 'available colors', //'other available options'
        ], 0);

        if ($this->show === 'everything' || $this->show === 'available colors') {
            $this->showColors();
        }

        if ($this->show === 'everything' || $this->show === 'available icons') {
            $this->showIcons();
        }
    }

    /**
     * output all available colors with text and background example
     */
    private function showColors()
    {
        $title = "\n\n      ********* AVAILABLE COLORS ********* \n\e[0m";
        $this->line("");
        $this->zooOutput($title);

        $colors = [];

        foreach ($this->zooOptions as $name => $color) {

            if (is_string($color) || strpos($name, 'COLOR_') !== 0) {
                continue;
            }

            if (is_array($color)) {
                $text = Zoo::SET_COLOR_RGB . implode(';', $color);
                $background = Zoo::SET_BG_RGB . implode(';', $color);
            } else if (is_integer($color)) {
                $text = Zoo::SET_COLOR . $color;
                $background = Zoo::SET_BG . $color;
            } else {
                continue;
            }

            $name = strtolower(preg_replace("/^COLOR_/", '', $name));

            $text = "\e[1;" . $text . "m I'm a {$name} text";
            $background = "\e[1;" . $background . "m I'm a {$name} background";

            $colors[] = [
                $name,
                $text . Zoo::RESET,
                $background . Zoo::RESET
            ];

            $colors[] = ['', '', '']; //add empty row
        }

        $this->table(['Name', 'Text', 'Background'], $colors);
    }

    /**
     * get and show all available icons
     */
    private function showIcons()
    {
        if ($this->show !== 'everything') {
            $category = $this->choice('Show only specific icons category?', [
                'SHOW ALL', 'animals', 'nature', 'emoticons', 'food', 'transport', 'others'
            ], 0);
        } else {
            $category = 'SHOW ALL';
        }

        $title = "\n\n      ********* AVAILABLE ICONS ********* \n\e[0m";
        $this->line("");
        $this->zooOutput($title);

        $icons = [];

        foreach ($this->zooOptions as $name => $option) {
            if (!isset($option['type']) || $option['type'] !== 'icon') {
                continue;
            }

            if ($category !== 'SHOW ALL' && $category !== $option['category']) {
                continue;
            }

            $icons[] = [
                strtolower($name),
                ' ' . $option['utf8'] . ' ',
                $option['category'] ?? ''
            ];
        }

        $this->table(['Name', 'Icon', 'Category'], $icons);
    }
}
