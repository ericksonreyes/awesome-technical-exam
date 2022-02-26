<?php


namespace App\Services;


/**
 * Interface JSONWebTokenDecoderInterface
 * @package App\Repository
 */
interface JSONWebTokenDecoderInterface
{
    /**
     * @param string $jwtString
     * @return array
     */
    public function decode(string $jwtString): array;
}