<?php

namespace Github\Domain\Model\Exception;

use InvalidArgumentException;

/**
 * Class InvalidEmailException
 * @package Github\Domain\Model\Exception
 */
class InvalidEmailException extends InvalidArgumentException
{

    protected $message = 'Invalid e-mail address format.';
}
