<?php


namespace Scheduler;

use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Scheduler\Interfaces\ApplicationInterface;

/**
 * Class Scenario
 * @package Scheduler
 */
class Scenario
{
    /**
     * @throws \Exception
     */
    public function run()
    {
        $logger = new Logger('runtime');
        unlink(__DIR__ . '/../logs/runtime.log');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/runtime.log'));
        $logger->pushHandler(new StreamHandler("php://stdout"));

        $applicationIds = range(1, 200);
        $repository = new Repository();
        $api = new Api(new Client(), new Config());
        $scheduler = new Scheduler();

        foreach ($applicationIds as $applicationId) {
            $logger->info("Fetching schedule for application {$applicationId}");
            $application = new Application($applicationId, $repository, $api);
            $scheduler->scheduleApplication($application);
        }

        $logger->info("Getting applications scheduled for 15:30");
        $time = new \DateTime("15:30");
        $apps = $scheduler->getScheduledApplicationsForTime($time);
        $logger->info("Applications scheduled for 15:30", ['apps' => array_map(function (ApplicationInterface $app) {
            return $app->getApplicationId();
        }, $apps)]);

        foreach ($apps as $application) {
//            $logger->info("Application {$application->getApplicationId()}", ['schedule' => $application->getSchedule()]);
            if (!in_array(930, $application->getSchedule())) {
                $logger->error("930 not found in application {$application->getApplicationId()}");
            }
        }

        $appsToReload = array_slice($scheduler->getScheduledApplications(), 0, 100);
        $logger->info("Updating schedule for first 100 apps");
        $scheduler->updateScheduleForApplications($appsToReload, true);

        $logger->info("Getting applications scheduled for 15:30");
        $time = new \DateTime("15:30");
        $apps = $scheduler->getScheduledApplicationsForTime($time);
        $logger->info("Applications scheduled for 15:30", ['apps' => array_map(function (ApplicationInterface $app) {
            return $app->getApplicationId();
        }, $apps)]);

        foreach ($apps as $application) {
//            $logger->info("Application {$application->getApplicationId()}", ['schedule' => $application->getSchedule()]);
            if (!in_array(930, $application->getSchedule())) {
                $logger->error("930 not found in application {$application->getApplicationId()}");
            }
        }

        $logger->info("Removing application with id 191");
        $application191 = $scheduler->getApplicationById(191);
        $scheduler->removeScheduledApplication($application191);

        $logger->info("Getting applications scheduled for 05:07");
        $time = new \DateTime("05:07");
        $apps = $scheduler->getScheduledApplicationsForTime($time);
        $logger->info("Applications scheduled for 05:07", ['apps' => array_map(function (ApplicationInterface $app) {
            return $app->getApplicationId();
        }, $apps)]);

        foreach ($apps as $application) {
//            $logger->info("Application {$application->getApplicationId()}", ['schedule' => $application->getSchedule()]);
            if (!in_array(307, $application->getSchedule())) {
                $logger->error("307 not found in application {$application->getApplicationId()}");
            }
        }

        $scheduler->scheduleApplication($application191, false);

        $checks = $scheduler->getApplicationById(180)->getNextChecks(5);
        $logger->info("Next five checks for application 180", ['checks' => $checks]);

        $checks = $scheduler->getApplicationById(191)->getNextChecks(5);
        $logger->info("Next five checks for application 191", ['checks' => $checks]);
    }
}
