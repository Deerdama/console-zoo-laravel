<?php

namespace Deerdama\ConsoleZoo;

trait ConsoleZoo
{
    /** @var OutputService */
    protected $zooService;

    /**
     * set default style (optional)
     *
     * @param array $param
     */
    public function zooSetDefaults($param)
    {
        $this->start();
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
    public function start()
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
        $this->start();
        $output = $this->zooService->prepareOutput($message, $icons, $param, $ignoreDefault);
        $this->output->writeln($output);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooInfo($message = "", $param = [])
    {
        $this->start();
        $output = $this->zooService->defaultOutputs($message, $param, 'info');
        $this->output->writeln($output);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooSuccess($message = "", $param = [])
    {
        $this->start();
        $output = $this->zooService->defaultOutputs($message, $param, 'success');
        $this->output->writeln($output);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooWarning($message = "", $param = [])
    {
        $this->start();
        $output = $this->zooService->defaultOutputs($message, $param, 'warning');
        $this->output->writeln($output);
    }

    /**
     * @param string $message
     * @param array $param
     */
    public function zooError($message = "", $param = [])
    {
        $this->start();
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
        $this->start();
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
}
















