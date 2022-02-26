<?php


namespace App\Services;

/**
 * Interface UniqueIdentifierGeneratorInterface
 * @package App\Services
 */
interface UniqueIdentifierGeneratorInterface
{

    /**
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public function generate(string $prefix = '', string $suffix = ''): string;

}