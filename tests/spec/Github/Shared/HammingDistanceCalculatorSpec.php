<?php

namespace spec\Github\Shared;

use Github\Shared\HammingDistanceCalculator;
use PhpSpec\ObjectBehavior;

/**
 * Class HammingDistanceCalculatorSpec
 * @package spec\Github\Shared
 */
class HammingDistanceCalculatorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(HammingDistanceCalculator::class);
    }

    public function it_can_calculate()
    {
        $firstNumber = mt_rand(1, 10);
        $secondNumber = mt_rand(1, 10);
        $this->calculate($firstNumber, $secondNumber)->shouldBeInt();
    }
}
