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
        $this->zooDefaults = $this->prepareParameters($param, true);
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
     * form the parameters and output message
     *
     * @param string $message
     * @param array $icons
     * @param array $param
     */
    public function zooOutput($message = "", $icons = [], $param = [], $ignoreDefault = false)
    {
        if (!$icons && $this->defaultIcons) {
            $icons = $this->defaultIcons;
        }

        $ansi = $this->prepareSequence($param, $ignoreDefault);
        $icons = $this->prepareIcons($icons);
        $message = $this->prepareMessage($message, $ansi);

        $this->output->writeln(" " . $icons . $ansi . $message);
    }

    /**
     * @param $parameters
     * @param bool $ignoreDefaults
     * @return array
     */
    private function prepareParameters($parameters, $ignoreDefaults = false)
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

        if ($ignoreDefaults !== true) {
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
    private function prepareSequence($param = [], $ignoreDefault = false): string
    {
        if (!count($param) && !count($this->zooDefaults)) {
            return "";
        }

        $sequenceParam = $this->prepareParameters($param, $ignoreDefault);

        if (!count($sequenceParam)) {
            return "";
        }

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

        $text = implode(' ', $result) . ' ';

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
     * check if the message contains inline parameters and return the final text
     *
     * @param string $message
     * @param string $mainSequence
     * @return string
     */
    private function prepareMessage($message, $mainSequence = "")
    {
        $message = $this->parseInlineParam($message, $mainSequence);
        $message = $this->parseInlineIcons($message);
        $result = $message . Zoo::RESET;

        return $result;
    }

    /**
     * check if the message contains inline parameters
     *
     * @param string $message
     * @param string $origSequence
     * @return mixed|string
     */
    private function parseInlineParam($message, $origSequence)
    {
        preg_match('/<zoo.*<\/zoo>/U', $message, $match);

        if ($match) {
            $inline = $match[0];
            preg_match('/(?<=>).*(?=<\/zoo>)/U', $inline, $content);
            preg_match('/(?<=color=").*(?=")/U', $inline, $color);
            preg_match('/(?<=background=").*(?=")/U', $inline, $background);

            if ($color) {
                preg_match('/(?<=\[).*(?=])/U', $color[0], $colorArr);
                $param['color'] = $colorArr ? explode(',', str_replace(' ', '', $colorArr[0])) : $color[0];
                $inline = preg_replace('/color=".*"/', '', $inline);
            }

            if ($background) {
                preg_match('/(?<=\[).*(?=])/U', $background[0], $backgroundArr);
                $param['background'] = $backgroundArr ? explode(',', str_replace(' ', '', $backgroundArr[0])) : $background[0];
                $inline = preg_replace('/background=".*"/U', '', $inline);
            }

            preg_match('/(?<=<zoo ).*(?=>)/U', $inline, $others);

            if ($others) {
                $others = explode(' ', $others[0]);

                foreach ($others as $other) {
                    if (!$other) {
                        continue; //don't include extra white spaces
                    }
                    $param[] = $other;
                }
            }

            $sequence = $this->prepareSequence($param, true);
            $result = $sequence . $content[0] . Zoo::RESET . $origSequence;

            $message = str_replace($match, $result, $message);
            return $this->parseInlineParam($message, $origSequence);
        }

        return $message;
    }

    /**
     * check if the message contains icons
     *
     * @param $message
     * @return mixed
     */
    private function parseInlineIcons($message)
    {
        preg_match('/<icon.*<\/icon>/U', $message, $inline);

        if ($inline) {
            preg_match('/(?<=<icon>).*(?=<\/icon>)/U', $inline[0], $icon);
            $icon = $icon ? $this->getIconCode($icon[0]) : "";
            $message = str_replace($inline, $icon, $message);

            return $this->parseInlineIcons($message);
        }

        return $message;
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooInfo($message = "", $param = [])
    {
        $parameters = Zoo::infoDefaults($param);
        $icons = $parameters['icons'];
        $message = isset($param['icons']) || !is_string($icons) ? $message : $message . "\e[0m " . $icons;
        unset($parameters['icons']);

        $this->zooOutput($message, $icons, $parameters, true);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooSuccess($message = "", $param = [])
    {
        $parameters = Zoo::successDefaults($param);
        $icons = $parameters['icons'];
        $message = isset($param['icons']) || !is_string($icons) ? $message : $message . "\e[0m " . $icons;
        unset($parameters['icons']);

        $this->zooOutput($message, $icons, $parameters, true);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooWarning($message = "", $param = [])
    {
        $parameters = Zoo::warningDefaults($param);
        $icons = $parameters['icons'];
        $message = isset($param['icons']) || !is_string($icons) ? $message : $message . "\e[0m " . $icons;
        unset($parameters['icons']);

        $this->zooOutput($message, $icons, $parameters, true);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooError($message = "", $param = [])
    {
        $parameters = Zoo::errorDefaults($param);
        $icons = $parameters['icons'];
        $message = isset($param['icons']) || !is_string($icons) ? $message : $message . "\e[0m " . $icons;
        unset($parameters['icons']);

        $this->zooOutput($message, $icons, $parameters, true);
    }

    /**
     * output with random icon
     *
     * @param string $message
     * @param array $param
     */
    public function surprise($message = "", $param = [])
    {
        $this->getConstants();
        $icon = null;

        if (!isset($param['category']) || !in_array($param['category'], Zoo::CATEGORIES)) {
            $param['category'] = null;
        }

        while (!$icon) {
            $rand = $this->constants[array_rand($this->constants)];

            if (isset($rand['type']) && $rand['type'] === 'icon'
                && (!$param['category'] || $param['category'] === $rand['category'])) {

                $icon = $rand['utf8'];
            }
        }

        unset($param['category']);
        unset($param['icons']);
        $message = $message . "\e[0m " . $icon;

        $this->zooOutput($message, $icon, $param);
    }
}
















