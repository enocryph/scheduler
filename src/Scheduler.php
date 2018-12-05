<?php


namespace Scheduler;

use Scheduler\Interfaces\ApplicationInterface;
use Scheduler\Interfaces\SchedulerInterface;

class Scheduler implements SchedulerInterface
{
    /**
     * @var ApplicationInterface[]
     */
    private $scheduledApplications;

    public function scheduleApplication(ApplicationInterface $application, bool $ignoreCached = true): void
    {
        if (!isset($this->scheduledApplications[$application->getApplicationId()])) {
            $application->loadSchedule($ignoreCached);
            $this->scheduledApplications[$application->getApplicationId()] = $application;
        }
    }

    public function removeScheduledApplication(ApplicationInterface $application): void
    {
        if (!isset($this->scheduledApplications[$application->getApplicationId()])) {
            unset($this->scheduledApplications[$application->getApplicationId()]);
        }
    }

    public function getScheduledApplications(): array
    {
        return $this->scheduledApplications;
    }

    public function getScheduledApplicationsForTime(\DateTime $time): array
    {
        $timezone = new \DateTimeZone('UTC');
        $today = new \DateTime(gmdate("Y-m-d"), $timezone);
        $minutes = ($time->getTimestamp() - $today->getTimestamp()) / 60;

        $application = [];

        foreach ($this->scheduledApplications as $application) {
            if (in_array($minutes, $application->getSchedule())) {
                $application[] = $application;
            }
        }

        return $application;
    }

    public function updateScheduleForApplications($applications, bool $ignoreCached = true): void
    {
        foreach ($applications as $application) {
            if (isset($this->scheduledApplications[$application->getApplicationId()])) {
                $this->scheduledApplications[$application->getApplicationId()]->loadSchedule($ignoreCached);
            }
        }
    }

    public function getApplicationById(int $applicationId): ?ApplicationInterface
    {
        return isset($this->scheduledApplications[$applicationId]) ? $this->scheduledApplications[$applicationId] : null;
    }

}
