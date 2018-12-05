<?php


namespace Scheduler;

use Scheduler\Interfaces\ApplicationInterface;
use Scheduler\Interfaces\RepositoryInterface;

/**
 * Class Repository
 * @package Scheduler
 */
class Repository implements RepositoryInterface
{
    /**
     * @var array
     */
    private $haystack = [];

    /**
     * @param ApplicationInterface $application
     * @param array $runtime
     */
    public function store(ApplicationInterface $application, array $runtime): void
    {
        $this->haystack[$application->getApplicationId()] = $runtime;
    }

    /**
     * @param ApplicationInterface $application
     * @return array|null
     */
    public function retrieve(ApplicationInterface $application): ?array
    {
        if (isset($this->haystack[$application->getApplicationId()])) {
            return $this->haystack[$application->getApplicationId()];
        }
        return null;
    }
}
