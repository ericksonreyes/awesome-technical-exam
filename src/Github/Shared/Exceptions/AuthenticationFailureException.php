<?php


namespace Github\Shared\Exceptions;


use Exception;

abstract class AuthenticationFailureException extends Exception
{
    protected $message = 'Authentication failed.';

    protected $code = 401;
}