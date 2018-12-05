<?php


namespace Scheduler\Interfaces;

/**
 * Interface SchedulerInterface
 * @package Scheduler\Interfaces
 */
interface SchedulerInterface
{

    /**
     * @param ApplicationInterface $application
     * @param bool $ignoreCached
     */
    public function scheduleApplication(ApplicationInterface $application, bool $ignoreCached = true): void;

    /**
     * @param ApplicationInterface $application
     * @return void
     */
    public function removeScheduledApplication(ApplicationInterface $application): void;

    /**
     * @return ApplicationInterface[]
     */
    public function getScheduledApplications(): array;

    /**
     * @param \DateTime $dateTime
     * @return ApplicationInterface[]
     */
    public function getScheduledApplicationsForTime(\DateTime $dateTime): array;


    /**
     * @param ApplicationInterface[] $applications
     * @param bool $ignoreCached
     */
    public function updateScheduleForApplications($applications, bool $ignoreCached = true): void;

    /**
     * @param int $applicationId
     * @return null|ApplicationInterface
     */
    public function getApplicationById(int $applicationId): ?ApplicationInterface;
}