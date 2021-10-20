<?php

namespace Deerdama\ConsoleZoo;

use Carbon\Carbon;

trait ConsoleZoo
{
    /** @var OutputService */
    protected $zooService;

    /** @var Carbon */
    protected $startTime;

    /** @var array */
    protected $laps = [];

    /**
     * set default style (optional)
     *
     * @param array $param
     */
    public function zooSetDefaults($param)
    {
        $this->init();
        $this->zooService->setDefaults($param);
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
     * check/create service instance
     */
    public function init()
    {
        if (!$this->zooService) {
            $this->zooService = app(OutputService::class);
        }
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
        $this->init();
        $output = $this->zooService->prepareOutput($message, $icons, $param, $ignoreDefault);
        $this->output->writeln($output);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooInfo($message = "", $param = [])
    {
        $this->init();
        $output = $this->zooService->defaultOutputs($message, $param, 'info');
        $this->output->writeln($output);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooSuccess($message = "", $param = [])
    {
        $this->init();
        $output = $this->zooService->defaultOutputs($message, $param, 'success');
        $this->output->writeln($output);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooWarning($message = "", $param = [])
    {
        $this->init();
        $output = $this->zooService->defaultOutputs($message, $param, 'warning');
        $this->output->writeln($output);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooError($message = "", $param = [])
    {
        $this->init();
        $output = $this->zooService->defaultOutputs($message, $param, 'error');
        $this->output->writeln($output);
    }

    /**
     * output with random icon and color
     *
     * @param string $message
     * @param array $param
     */
    public function surprise($message = "", $param = [])
    {
        $this->init();
        $output = $this->zooService->surpriseOutput($message, $param);
        $this->output->writeln($output);
    }

    /**
     * output empty lines
     *
     * @param int $lines
     */
    public function br($lines = 1)
    {
        for ($x = 1; $x <= $lines; $x++) {
            $this->line("");
        }
    }

    /**
     * output current timestamp
     *
     * @param array $param
     */
    public function time($param = [])
    {
        $this->init();
        $output = $this->zooService->getTimestamp($param);
        $this->output->writeln($output);
    }

    /**
     * set the initial time
     */
    public function start()
    {
        $this->startTime = Carbon::now();
    }

    /**
     * output the duration from the set start
     *
     * @param array $param
     */
    public function duration($param = [])
    {
        $this->init();
        $parameters = array_merge(config('zoo.duration'), $param);

        try {
            $duration = $this->zooService->getDuration($this->startTime, $parameters['format']);
        } catch (\Throwable $e) {
            $this->timerError();
        }
        unset($parameters['format']);
        $this->zoo($duration, $parameters);
    }

    /**
     * add a lap and output the duration if $output == true
     *
     * @param bool $output
     * @param array $param
     */
    public function lap($output = true, $param = [])
    {
        $this->init();

        try {
            $parameters = array_merge(config('zoo.duration'), $param);
            $this->zooService->addLap($this->laps, $this->startTime, $parameters);

            if ($output === true) {
                $parameters = array_merge(config('zoo.lap_duration'), $param);
                $outputText = end($this->laps)['duration'];

                if ($parameters['prepend_text']) {
                    $outputText = str_replace('{lap_number}', count($this->laps), $parameters['prepend_text']) . $outputText;
                }

                if ($parameters['append_text']) {
                    $outputText = $outputText . str_replace('{lap_number}', count($this->laps), $parameters['append_text']);
                }

                unset($parameters['format'], $parameters['prepend_text'], $parameters['append_text']);
                $this->zoo($outputText, $parameters);
            }
        } catch (\Throwable $e) {
            $this->timerError();
        }
    }

    public function timerError()
    {
        $this->zooError('To see the current duration, you need to start the timer first!');
        $this->br();
        $this->zoo('Call <zoo underline>$this->start();</zoo> to start the timer', ['color' => 'yellow_light_2', 'italic', 'no_bold']);
        exit;
    }
}