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
        $this->zooSetDefaults([
            'background' => 'blue',
            'bold',
            'italic'
        ]);

        $this->show = $this->choice('Show me....', [
            'everything', 'available icons', 'available colors'
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
        $colors = new ReflectionClass(Color::class);
        $colors = $colors->getConstants();
        $title = "\n\n      ********* AVAILABLE COLORS ********* \n\e[0m";
        $this->line("");
        $this->zooOutput($title);

        $result = [];

        foreach ($colors as $name => $color) {
            if (is_array($color)) {
                $text = Others::SET_COLOR_RGB . implode(';', $color);
                $background = Others::SET_BG_RGB . implode(';', $color);
            } else if (is_integer($color)) {
                $text = Others::SET_COLOR . $color;
                $background = Others::SET_BG . $color;
            } else {
                continue;
            }

            $name = strtolower($name);

            $text = "\e[1;" . $text . "m I'm a {$name} text";
            $background = "\e[1;" . $background . "m     I'm a {$name} background    ";

            $result[] = [
                $name,
                $text . Others::RESET,
                $background . Others::RESET
            ];

            $result[] = ['', '', '']; //add empty row
        }

        $this->table(['Name', 'Text', 'Background'], $result);
    }

    /**
     * get and show all available icons
     */
    private function showIcons()
    {
        $title = "\n\n      ********* AVAILABLE ICONS ********* \n\e[0m";
        $this->line("");
        $this->zooOutput($title);
        $icons = new ReflectionClass(Icon::class);
        $icons = $icons->getConstants();
        $categories = Icon::CATEGORIES;
        array_unshift($categories, 'SHOW ALL');
        $result = [];

        if ($this->show !== 'everything') {
            $category = $this->choice('Show only specific icons category?', $categories, 0);
        } else {
            $category = $categories[0];
        }

        foreach ($icons as $name => $icon) {
            if (!isset($icon['utf8']) || ($category !== 'SHOW ALL' && $category !== $icon['category'])) {
                continue;
            }

            $result[] = [
                strtolower($name),
                ' ' . $icon['utf8'] . ' ',
                $icon['category'] ?? ''
            ];
        }

        $this->table(['Name', 'Icon', 'Category'], $result);
    }
}
