<?php


namespace App\Services;

use DateTimeImmutable;

/**
 * Interface SearchHistoryServiceInterface
 * @package App\Services
 */
interface SearchHistoryServiceInterface
{

    /**
     * @param string $email
     * @param string $searchString
     * @param DateTimeImmutable $searchedOn
     * @param int $resultCount
     * @param float $searchSpeed
     */
    public function record(
        string $email,
        string $searchString,
        DateTimeImmutable $searchedOn,
        int $resultCount,
        float $searchSpeed
    ): void;
}