<?php


namespace Scheduler;

use GuzzleHttp\Client;
use Scheduler\Interfaces\ApiInterface;
use Scheduler\Interfaces\ApplicationInterface;

/**
 * Class Api
 * @package Scheduler
 */
class Api implements ApiInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Config
     */
    private $config;

    /**
     * Api constructor.
     * @param Client $client
     * @param Config $config
     */
    public function __construct(Client $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param ApplicationInterface $application
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRunTimes(ApplicationInterface $application): array
    {
        $endpoint = $this->config->getParameter('RUNTIME_ENDPOINT');
        $response = $this->client->request('GET', "$endpoint/{$application->getApplicationId()}");

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents());
        }
    }
}
