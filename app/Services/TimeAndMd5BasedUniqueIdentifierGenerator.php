<?php


namespace App\Services;

/**
 * Class TimeAndMd5BasedUniqueIdentifierGenerator
 * @package App\Services
 */
class TimeAndMd5BasedUniqueIdentifierGenerator implements UniqueIdentifierGeneratorInterface
{
    /**
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public function generate(string $prefix = '', string $suffix = ''): string
    {
        $uniqueIdentifier = md5(microtime());
        $prefix = '';
        $suffix = '';
        return $prefix . $uniqueIdentifier . $suffix;
    }


}