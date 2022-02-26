<?php


namespace App\Repository;


/**
 * Interface JSONWebTokenGeneratorInterface
 * @package App\Repository
 */
interface JSONWebTokenGeneratorInterface
{
    /**
     * @param array $payload
     * @return string
     */
    public function generate(array $payload): string;
}