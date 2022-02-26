<?php


namespace App\Repository;


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