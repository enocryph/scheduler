<?php


namespace Scheduler;

use GuzzleHttp\Client;
use Scheduler\Interfaces\ApiInterface;
use Scheduler\Interfaces\ApplicationInterface;

class Api implements ApiInterface
{
    private $client;

    private $config;

    public function __construct(Client $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function getRunTimes(ApplicationInterface $application): array
    {
        $endpoint = $this->config->getParameter('RUNTIME_ENDPOINT');
        $response = $this->client->request('GET', "$endpoint/{$application->getApplicationId()}");

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents());
        }
    }
}