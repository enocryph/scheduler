<?php


namespace Scheduler;

use Scheduler\Interfaces\ApiInterface;
use Scheduler\Interfaces\ApplicationInterface;
use Scheduler\Interfaces\RepositoryInterface;

class Application implements ApplicationInterface
{
    private $applicationId;

    private $repository;

    private $api;

    public function __construct(int $applicationId, RepositoryInterface $repository, ApiInterface $api)
    {
        $this->applicationId = $applicationId;
        $this->repository = $repository;
        $this->api = $api;
    }

    public function getApplicationId(): int
    {
        return $this->applicationId;
    }

    public function getSchedule(bool $ignoreCached): array
    {
        $runtime = null;

        if (!$ignoreCached) {
            $runtime = $this->repository->retrieve($this);
        }

        if (is_null($runtime)) {
            $runtime = $this->api->getRunTimes($this);
        }

        return $runtime;
    }

    public function getNextChecks(int $numberOfChecks = 1): array
    {
        // TODO: Implement getNextChecks() method.
    }

}