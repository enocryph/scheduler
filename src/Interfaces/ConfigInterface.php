<?php


namespace Scheduler\Interfaces;

/**
 * Interface ConfigInterface
 * @package Scheduler\Interfaces
 */
interface ConfigInterface
{
    /**
     * @param $name
     * @return mixed
     */
    public function getParameter($name);
}
