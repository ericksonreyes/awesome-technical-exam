<?php

namespace Github\Shared;

/**
 * Class HammingDistanceCalculator
 * @package Github\Shared
 */
class HammingDistanceCalculator
{

    /**
     * @param int $firstNumber
     * @param int $secondNumber
     * @return int
     */
    public function calculate(int $firstNumber, int $secondNumber): int
    {
        $differenceInBits = $firstNumber ^ $secondNumber;
        $hammingDistance = 0;

        while ($differenceInBits > 0)
        {
            $hammingDistance += $differenceInBits & 1;
            $differenceInBits >>= 1;
        }

        return $hammingDistance;
    }
}
