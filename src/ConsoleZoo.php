<?php

namespace Deerdama\ConsoleZoo;

use ReflectionClass;

trait ConsoleZoo
{
    /** @var array */
    protected $zooDefaults = [];

    /** @var array */
    protected $constants = [];

    /** @var array */
    protected $defaultIcons = [];

    /**
     * set default style (optional)
     *
     * @param array $param
     */
    public function zooSetDefaults($param)
    {
        $this->defaultIcons = $param['icons'] ?? [];
        unset($param['icons']);
        $this->zooDefaults = $this->prepareParameters($param, false);
    }

    /**
     * form the parameters and output message
     *
     * @param string $message
     * @param array $icons
     * @param array $param
     */
    public function zooOutput($message = "", $icons = [], $param = [])
    {
        if (!$icons && $this->defaultIcons) {
            $icons = $this->defaultIcons;
        }

        $ansi = $this->prepareSequence($param);
        $icons = $this->prepareIcons($icons);
        $message = $this->prepareMessage($message);

        $this->output->writeln(" " . $icons . $ansi . $message);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zoo($message = "", $param = [])
    {
        $icons = $param['icons'] ?? [];
        unset($param['icons']);

        $this->zooOutput($message, $icons, $param);
    }

    /**
     * @param $parameters
     * @param bool $compare
     * @return array
     */
    private function prepareParameters($parameters, $compare = true)
    {
        $this->getConstants();
        $currentDefaults = $this->zooDefaults;
        $newParam = [];

        foreach ($parameters as $key => $value) {
            if (is_string($key)) {
                $newParam[$key] = $value;
            } else {
                if (substr($value, 0, 3) === 'no_') {
                    unset($currentDefaults[substr($value, 3)]);
                    unset($parameters[substr($value, 3)]);
                    unset($newParam[substr($value, 3)]);
                } else if (isset($this->constants[strtoupper($value)])) {
                    $newParam[$value] = $this->constants[strtoupper($value)];
                }
            }
        }

        $result = $this->getColors($newParam);

        if ($compare !== false) {
            $result = array_merge($currentDefaults, $result);
        }

        return $result;
    }

    /**
     * check if the constants were loaded, get them if not
     */
    private function getConstants()
    {
        if (!count($this->constants)) {
            $refl = new ReflectionClass(Zoo::class);
            $this->constants = $refl->getConstants();
        }
    }

    /**
     * get the ansi sequences for color parameters
     *
     * @param array $parameters
     * @return array
     */
    private function getColors($parameters)
    {
        if (isset($parameters['color'])) {
            $color = $this->findColor($parameters['color']);

            if (is_array($color)) {
                $parameters['color'] = Zoo::SET_COLOR_RGB . implode(';', $color);
            } else if (is_integer($color)) {
                $parameters['color'] = Zoo::SET_COLOR . $color;
            } else {
                unset($parameters['color']);
            }
        }

        if (isset($parameters['background'])) {
            $color = $this->findColor($parameters['background']);

            if (is_array($color)) {
                $parameters['background'] = Zoo::SET_BG_RGB . implode(';', $color);
            } else if (is_integer($color)) {
                $parameters['background'] = Zoo::SET_BG . $color;
            } else {
                unset($parameters['background']);
            }
        }

        return $parameters;
    }

    /**
     * @param $color
     * @return int|array|null
     */
    private function findColor($color)
    {
        if (is_string($color)) {
            $color = str_replace(' ', '_', $color);
            $color = strpos($color, '_color') ? $color : $color . '_color';
            $color = isset($this->constants[strtoupper($color)]) ? $this->constants[strtoupper($color)] : null;
        }

        return $color;
    }

    /**
     * prepare ansi escape sequence for effects and style
     *
     * @param array $param
     * @return string
     */
    private function prepareSequence($param = []): string
    {
        if (!count($param) && !count($this->zooDefaults)) {
            return "";
        }

        $sequenceParam = $this->prepareParameters($param);
        $ansi = "\e[" . implode(';', $sequenceParam);
        $ansi = rtrim($ansi, ';') . 'm';

        return $ansi;
    }

    /**
     * @param array|string $icons
     * @return string
     */
    private function prepareIcons($icons): string
    {
        if (!$icons || !count((array)$icons)) {
            return "";
        }

        if (is_array($icons)) {
            foreach ($icons as $icon) {
                $result[] = $this->getIconCode($icon);
            }
        } else {
            $result[] = $this->getIconCode($icons);
        }

        $text = implode(' ', $result) . '  ';

        return $text;
    }

    /**
     * @param string $icon
     * @return string
     */
    private function getIconCode($icon)
    {
        if (is_array($icon) && isset($icon['utf8'])) {
            $icon = $icon['utf8'];
        }

        if (is_string($icon) && isset($this->constants[strtoupper($icon)])) {
            $icon = $this->constants[strtoupper($icon)]['utf8'];
        }

        return $icon;
    }

    /**
     * @param string $message
     * @return string
     * @todo add option and process inline parameters
     *
     */
    private function prepareMessage($message)
    {
        $result = $message . Zoo::RESET;

        return $result;
    }

    public function zooInfo($message = "", $param = [])
    {
        $icons = $param['icons'] ?? [];
        unset($param['icons']);

        $param['color'] = 'blue';
        $this->zooOutput($message, $icons, $param);
    }

    public function zooSuccess($message = "", $param = [])
    {
        $icons = $param['icons'] ?? [];
        unset($param['icons']);
        $param['color'] = 'green';

        $this->zooOutput($message, $icons, $param);
    }
}
















