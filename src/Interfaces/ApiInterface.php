<?php


namespace Scheduler\Interfaces;

use GuzzleHttp\Client;
use Scheduler\Config;

/**
 * Interface ApiInterface
 * @package Scheduler\Interfaces
 */
interface ApiInterface
{
    /**
     * ApiInterface constructor.
     * @param Client $client
     * @param Config $config
     */
    public function __construct(Client $client, Config $config);


    /**
     * @param ApplicationInterface $application
     * @return array
     */
    public function getRunTimes(ApplicationInterface $application): array;
}
