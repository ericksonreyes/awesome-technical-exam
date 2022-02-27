<?php

namespace Github\Domain\Model\Exception;

use Github\Shared\Exceptions\AuthenticationFailureException;

/**
 * Class ExpiredSessionException
 * @package Github\Domain\Model\Exception
 */
class ExpiredSessionException extends AuthenticationFailureException
{
    protected $message = 'Session expired';
}
