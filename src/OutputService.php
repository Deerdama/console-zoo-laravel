<?php

namespace Deerdama\ConsoleZoo;

use Carbon\Carbon;

class OutputService
{
    /** @var array */
    protected $icons;

    /** @var array */
    protected $colors;

    /** @var array */
    protected $others;

    /** @var array */
    protected $currentDefaults = [];

    /** @var array */
    protected $defaultIcons = [];


    public function __construct()
    {
        $icons = new \ReflectionClass(Icon::class);
        $this->icons = $icons->getConstants();

        $colors = new \ReflectionClass(Color::class);
        $this->colors = $colors->getConstants();

        $others = new \ReflectionClass(Others::class);
        $this->others = $others->getConstants();
    }

    /**
     * set requested default parameters
     *
     * @param array $param
     */
    public function setDefaults($param)
    {
        $this->defaultIcons = $param['icons'] ?? [];
        unset($param['icons']);
        $this->currentDefaults = $this->prepareParameters($param, true);
        $this->useTimestamps($param, true);
    }

    /**
     * process all param, icons and string for final output
     *
     * @param string $message
     * @param array $icons
     * @param array $param
     * @param bool $ignoreDefault
     * @return string
     */
    public function prepareOutput($message, $icons, $param, $ignoreDefault = false): string
    {
        $ansi = $this->prepareSequence($param, $ignoreDefault);
        $icons = $this->prepareIcons($icons);

        if ($this->useTimestamps($param) === true) {
            $timestamp = $this->getTimestamp();
        }

        $message = $this->prepareMessage($message, $ansi);
        $output = ($timestamp ?? ' ') . $icons . $ansi . $message;

        return $output;
    }

    /**
     * prepare the escape codes sequence
     *
     * @param array $param
     * @param bool $ignoreDefault
     * @return string
     */
    private function prepareSequence($param = [], $ignoreDefault = false): string
    {
        if (!count($param) && !count($this->currentDefaults)) {
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
     * @param $parameters
     * @param bool $ignoreDefaults
     * @return array
     */
    private function prepareParameters($parameters, $ignoreDefaults = false)
    {
        $currentDefaults = $this->currentDefaults;
        $newParam = [];

        foreach ($parameters as $key => $value) {
            if (is_string($key)) {
                $newParam[$key] = $value;
            } else {
                if (substr($value, 0, 3) === 'no_') {
                    unset($currentDefaults[substr($value, 3)]);
                    unset($parameters[substr($value, 3)]);
                    unset($newParam[substr($value, 3)]);
                }

                if (isset($this->others[strtoupper($value)])) {
                    $newParam[$value] = $this->others[strtoupper($value)];
                }
            }
        }

        $result = $this->getColors($newParam);

        if ($ignoreDefaults !== true) {
            $result = array_merge($currentDefaults, $result);
        }

        unset($result['timestamp']);

        return $result;
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
                $parameters['color'] = Others::SET_COLOR_RGB . implode(';', $color);
            } else if (is_integer($color)) {
                $parameters['color'] = Others::SET_COLOR . $color;
            } else {
                unset($parameters['color']);
            }
        }

        if (isset($parameters['background'])) {
            $color = $this->findColor($parameters['background']);

            if (is_array($color)) {
                $parameters['background'] = Others::SET_BG_RGB . implode(';', $color);
            } else if (is_integer($color)) {
                $parameters['background'] = Others::SET_BG . $color;
            } else {
                unset($parameters['background']);
            }
        }

        return $parameters;
    }

    /**
     * try to find the requested color
     *
     * @param $color
     * @param bool $final
     * @return mixed|string|null
     */
    private function findColor($color, $final = false)
    {
        if (!is_string($color)) {
            return $color;
        }

        $color = strtoupper(str_replace(' ', '_', $color));

        if (isset($this->colors[$color])) {
            return $this->colors[$color];
        }

        if ($final === true) {
            return null;
        }

        preg_match('/(_DARK|_LIGHT|_BRIGHT)$/', $color, $suffix);
        preg_match('/^(DARK|LIGHT|BRIGHT)_./U', $color, $prefix);
        preg_match('/[0-9]$/', $color, $numberSuffix);

        if ($suffix) {
            return $this->findColor($color . '_1');
        } elseif ($prefix) {
            preg_match('/[0-9]$/', $prefix[0], $number);

            if ($number) {
                $color = str_replace($prefix[0], '', $color);
                $color = $color . '_' . $prefix[0];
            } else {
                $suffix = substr($prefix[0], 0, strlen($prefix[0]) - 1);
                $color = str_replace($suffix, '', $color);
                $color = $color . '_' . $suffix . '1';
            }

            return $this->findColor(ltrim($color, '_'));
        } elseif ($numberSuffix) {
            $color = str_replace($numberSuffix[0], '', $color);

            if (substr($color, -1, 1) !== '_') {
                $color = $color . '_' . $numberSuffix[0];
            } elseif ((int)$numberSuffix[0] > 1) {
                $number = (int)$numberSuffix[0] - 1;
                $color = $color . (string)$number;
            }

            return $this->findColor($color);
        } else {
            $color = preg_replace('/[0-9]|DARK|LIGHT|_/', '', $color);
            return $this->findColor($color, true);
        }
    }

    /**
     * @param $icons
     * @return string
     */
    private function prepareIcons($icons): string
    {
        $icons = $icons || $icons === false ? $icons : $this->defaultIcons;

        if (!$icons) {
            return "";
        }

        if (is_array($icons) && !isset($icons['utf8'])) {
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

        if (is_string($icon)) {
            $icon = str_replace(" ", "_", $icon);
            $icon = isset($this->icons[strtoupper($icon)]) ? $this->icons[strtoupper($icon)]['utf8'] : $icon;
        }

        return $icon;
    }

    /**
     * prepare the final message string
     *
     * @param string $message
     * @param string $mainSequence
     * @return string
     */
    private function prepareMessage($message, $mainSequence = "")
    {
        $message = $this->parseInlineParam($message, $mainSequence);
        $message = $this->parseInlineIcons($message);
        $result = $message . Others::RESET;

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
        $param = [];

        if ($match) {
            $inline = $match[0];
            preg_match('/(?<=>).*(?=<\/zoo>)/U', $inline, $content);
            preg_match('/(?<=color=[",\']).*(?=[",\'])/U', $inline, $color);
            preg_match('/(?<=background=[",\']).*(?=[",\'])/U', $inline, $background);

            if ($color) {
                preg_match('/(?<=\[).*(?=])/U', $color[0], $colorArr);
                $param['color'] = $colorArr ? explode(',', str_replace(' ', '', $colorArr[0])) : $color[0];
                $inline = preg_replace('/color=[",\'].*[",\']/U', '', $inline);
            }

            if ($background) {
                preg_match('/(?<=\[).*(?=])/U', $background[0], $backgroundArr);
                $param['background'] = $backgroundArr ? explode(',', str_replace(' ', '', $backgroundArr[0])) : $background[0];
                $inline = preg_replace('/background=[",\'].*[",\']/U', '', $inline);
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
            $result = $sequence . $content[0] . Others::RESET . $origSequence;
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
     * get output for the default methods (info, success, warning, error)
     * @param string $message
     * @param array $param
     * @param string $type
     * @return string
     */
    public function defaultOutputs($message, $param, $type)
    {
        $default = config("zoo.{$type}");
        $parameters = array_merge($default, $param);
        $icons = $parameters['icons'];
        unset($parameters['icons']);
        $message = $message . "\e[0m " . $this->appendIcons($icons);
        $output = $this->prepareOutput($message, $icons, $parameters, true);

        return $output;
    }

    /**
     * form output for the surprise method
     *
     * @param string $message
     * @param array $param
     * @return string
     */
    public function surpriseOutput($message, $param)
    {
        $icon = $this->getRandomIcon($param['category'] ?? null);
        $message = $message . "\e[0m " . $icon;

        unset($param['category']);
        unset($param['icons']);


        if (!isset($param['color']) && !isset($this->currentDefaults['color'])) {
            $param['color'] = array_rand($this->colors);
        }

        $output = $this->prepareOutput($message, $icon, $param);

        return $output;
    }

    /**
     * get icons to add at the end of the message
     *
     * @param array|string $icons
     * @return string
     */
    private function appendIcons($icons): string
    {
        if (is_array($icons) && !isset($icons['utf8'])) {
            $icons = array_reverse($icons);
        }

        return $this->prepareIcons($icons);
    }

    /**
     * get a random icon or random from a specific category
     *
     * @param string|null $category
     * @return string
     */
    private function getRandomIcon($category)
    {
        $icon = null;
        $category = !in_array($category, Icon::CATEGORIES) ? null : $category;

        while (!$icon) {
            $rand = $this->icons[array_rand($this->icons)];

            if (!$category || (isset($rand['category']) && $category === $rand['category'])) {
                $icon = $rand['utf8'] ?? null;
            }
        }

        return $icon;
    }

    /**
     * check if timestamps should be added to the current output
     *
     * @param array $param
     * @param bool $defaults
     */
    public function useTimestamps($param = [], $defaults = false): bool
    {
        if (isset($param['timestamp']) && $param['timestamp'] === false) {
            $inParam = false;
        }

        if (in_array('timestamp', $param)
            || (isset($param['timestamp']) && $param['timestamp'] === true)) {
            $inParam = true;
        }

        if (isset($inParam)) {
            $defaults === true ? $this->currentDefaults['timestamp'] = $inParam : null;
            return $inParam;
        }

        if (isset($this->currentDefaults['timestamp'])) {
            return $this->currentDefaults['timestamp'];
        }

        return config('zoo.timestamp');
    }

    /**
     * @return string
     */
    public function getTimestamp($param = [])
    {
        $timestamps = array_merge(config('zoo.time'), $param);

        if (!isset($timestamps['tz'])) {
            $timestamps['tz'] = config('app.timezone') ?? 'UTC';
        }

        $time = Carbon::now($timestamps['tz'])->format($timestamps['format']);
        $icon = $timestamps['icons'];
        $timestamps['timestamp'] = false;
        unset($timestamps['icons'], $timestamps['tz'], $timestamps['format']);
        $result = $this->prepareOutput($time, $icon, $timestamps, true);

        return $result . ' ';
    }

    /**
     * get the formatted duration
     *
     * @param Carbon $start
     * @param null|string $format
     * @return string
     */
    public function getDuration($start, $format = null)
    {
        $format = $format ?: config('zoo.duration.format');
        $diff = $start->diff();

        if (!preg_match('/%d/i', $format)) {
            $diff->h = $diff->h + ($diff->d * 24);
        } else if (!$diff->d) {
            $format = preg_replace('/(?=%d).*(?=%)/iU', '', $format);
        }

        if (!preg_match('/%h/i', $format)) {
            $diff->i = $diff->i + ($diff->h * 60);
        } else if (!$diff->h) {
            $format = preg_replace('/(?=%h).*(?=%)/iU', '', $format);
        }

        if (!preg_match('/%i/i', $format)) {
            $diff->s = $diff->s + ($diff->i * 60);
        } else if (!$diff->i) {
            $format = preg_replace('/(?=%i).*(?=%)/iU', '', $format);
        }

        return $diff->format($format);
    }
}
