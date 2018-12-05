<?php


namespace Scheduler\Interfaces;

/**
 * Interface ApplicationInterface
 * @package Scheduler\Interfaces
 */
interface ApplicationInterface
{

    /**
     * ApplicationInterface constructor.
     * @param int $applicationId
     * @param RepositoryInterface $repository
     * @param ApiInterface $api
     */
    public function __construct(int $applicationId, RepositoryInterface $repository, ApiInterface $api);

    /**
     * @return int
     */
    public function getApplicationId(): int;


    /**
     * @param bool $ignoreCached
     * @return array
     */
    public function getSchedule(bool $ignoreCached): array;

    /**
     * @param int $numberOfChecks
     * @return array
     */
    public function getNextChecks(int $numberOfChecks = 1): array;
}
