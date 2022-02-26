<?php


namespace App\Services;


use App\Models\SearchHistoryModel;
use DateTimeImmutable;

/**
 * Class EloquentAwareSearchHistoryService
 * @package App\Services
 */
class EloquentAwareSearchHistoryService implements SearchHistoryServiceInterface
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
    ): void
    {
        $searchHistory = new SearchHistoryModel();
        $searchHistory->email =$email;
        $searchHistory->searchString = $searchString;
        $searchHistory->searchedOn = $searchedOn;
        $searchHistory->resultCount = $resultCount;
        $searchHistory->searchSpeed = $searchSpeed;
        $searchHistory->save();
    }


}