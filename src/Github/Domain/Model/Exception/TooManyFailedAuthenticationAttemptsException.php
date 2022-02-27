<?php

namespace Github\Domain\Model\Exception;

use Github\Shared\Exceptions\AuthenticationFailureException;

/**
 * Class TooManyFailedAuthenticationAttemptsException
 * @package Github\Domain\Model\Exception
 */
class TooManyFailedAuthenticationAttemptsException extends AuthenticationFailureException
{

    protected $message = 'Too many failed authentication attempts.';
}
