<?php


namespace Scheduler;

use Scheduler\Interfaces\ApplicationInterface;
use Scheduler\Interfaces\RepositoryInterface;

class Repository implements RepositoryInterface
{
    private $haystack = [];

    public function store(ApplicationInterface $application, array $runtime): void
    {
        $this->haystack[$application->getApplicationId()] = $runtime;
    }

    public function retrieve(ApplicationInterface $application): ?array
    {
        if (isset($this->haystack[$application->getApplicationId()])) {
            return $this->haystack[$application->getApplicationId()];
        }
        return null;
    }
}