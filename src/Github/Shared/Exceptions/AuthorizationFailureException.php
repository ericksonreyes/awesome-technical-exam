<?php


namespace Github\Shared\Exceptions;


abstract class AuthorizationFailureException
{
    protected $message = 'Access denied.';

    protected $code = 403;

}