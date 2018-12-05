<?php


namespace Scheduler\Interfaces;

/**
 * Interface RepositoryInterface
 * @package Scheduler\Interfaces
 */
interface RepositoryInterface
{

    /**
     * @param ApplicationInterface $application
     * @param array $runtime
     * @return void
     */
    public function store(ApplicationInterface $application, array $runtime): void;

    /**
     * @param ApplicationInterface $application
     * @return array
     */
    public function retrieve(ApplicationInterface $application): ?array;
}
