<?php


namespace Scheduler;

use \Scheduler\Interfaces\ConfigInterface;

/**
 * Class Config
 * @package Scheduler
 */
class Config implements ConfigInterface
{
    /**
     * @param $name
     * @return array|false|mixed|string
     */
    public function getParameter($name)
    {
        return getenv($name);
    }
}
