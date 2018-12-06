<?php


namespace Scheduler;

use Scheduler\Interfaces\ApiInterface;
use Scheduler\Interfaces\ApplicationInterface;
use Scheduler\Interfaces\RepositoryInterface;

/**
 * Class Application
 * @package Scheduler
 */
class Application implements ApplicationInterface
{
    /**
     * @var int
     */
    private $applicationId;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var ApiInterface
     */
    private $api;

    /**
     * Application constructor.
     * @param int $applicationId
     * @param RepositoryInterface $repository
     * @param ApiInterface $api
     */
    public function __construct(int $applicationId, RepositoryInterface $repository, ApiInterface $api)
    {
        $this->applicationId = $applicationId;
        $this->repository = $repository;
        $this->api = $api;
    }

    /**
     * @return int
     */
    public function getApplicationId(): int
    {
        return $this->applicationId;
    }

    /**
     * @param bool $ignoreCached
     * @return array
     */
    public function getSchedule(bool $ignoreCached = false): array
    {
        $runtime = null;

        if (!$ignoreCached) {
            $runtime = $this->repository->retrieve($this);
        }

        if (is_null($runtime)) {
            $this->loadSchedule();
            $runtime = $this->repository->retrieve($this);
        }

        return $runtime;
    }

    /**
     * @param bool $ignoreCached
     */
    public function loadSchedule(bool $ignoreCached = true): void
    {
        if ($ignoreCached) {
            $this->repository->store($this, $this->api->getRunTimes($this));
        } elseif (empty($this->repository->retrieve($this))) {
            $this->repository->store($this, $this->api->getRunTimes($this));
        }
    }

    /**
     * @param int $numberOfChecks
     * @return array
     */
    public function getNextChecks(int $numberOfChecks = 1): array
    {
        $schedule = $this->getSchedule();
        $today = new \DateTime(date("Y-m-d"));
        $time = new \DateTime("now");
        $minutes = ($time->getTimestamp() - $today->getTimestamp()) / 60;
        $counter = 0;
        $result = [];

        foreach ($schedule as $item) {
            if ($counter >= $numberOfChecks) {
                break;
            }

            if ($item > $minutes) {
                $result[] = $item;
                $counter++;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        $result = ['applicationId' => $this->applicationId, 'schedule' => $this->getSchedule()];
        return $result;
    }

}
