<?php


namespace Scheduler;

use Scheduler\Interfaces\ApplicationInterface;
use Scheduler\Interfaces\SchedulerInterface;

/**
 * Class Scheduler
 * @package Scheduler
 */
class Scheduler implements SchedulerInterface
{
    /**
     * @var ApplicationInterface[]
     */
    private $scheduledApplications;

    /**
     * @param ApplicationInterface $application
     * @param bool $ignoreCached
     */
    public function scheduleApplication(ApplicationInterface $application, bool $ignoreCached = true): void
    {
        if (!isset($this->scheduledApplications[$application->getApplicationId()])) {
            $application->loadSchedule($ignoreCached);
            $this->scheduledApplications[$application->getApplicationId()] = $application;
        }
    }

    /**
     * @param ApplicationInterface $application
     */
    public function removeScheduledApplication(ApplicationInterface $application): void
    {
        if (!isset($this->scheduledApplications[$application->getApplicationId()])) {
            unset($this->scheduledApplications[$application->getApplicationId()]);
        }
    }

    /**
     * @return array
     */
    public function getScheduledApplications(): array
    {
        return $this->scheduledApplications;
    }

    /**
     * @param \DateTime $time
     * @return ApplicationInterface[]
     */
    public function getScheduledApplicationsForTime(\DateTime $time): array
    {
        $timezone = new \DateTimeZone('UTC');
        $today = new \DateTime(gmdate("Y-m-d"), $timezone);
        $minutes = ($time->getTimestamp() - $today->getTimestamp()) / 60;

        $applications = [];

        foreach ($this->scheduledApplications as $application) {
            if (in_array($minutes, $application->getSchedule())) {
                $applications[] = $application;
            }
        }

        return $applications;
    }

    /**
     * @param ApplicationInterface[] $applications
     * @param bool $ignoreCached
     */
    public function updateScheduleForApplications($applications, bool $ignoreCached = true): void
    {
        foreach ($applications as $application) {
            if (isset($this->scheduledApplications[$application->getApplicationId()])) {
                $this->scheduledApplications[$application->getApplicationId()]->loadSchedule($ignoreCached);
            }
        }
    }

    /**
     * @param int $applicationId
     * @return null|ApplicationInterface
     */
    public function getApplicationById(int $applicationId): ?ApplicationInterface
    {
        return isset($this->scheduledApplications[$applicationId]) ? $this->scheduledApplications[$applicationId] : null;
    }

}
