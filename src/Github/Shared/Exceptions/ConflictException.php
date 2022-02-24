<?php


namespace Github\Shared\Exceptions;


use InvalidArgumentException;

/**
 * Class ConflictException
 * @package Github\Shared\Exception
 */
abstract class ConflictException extends InvalidArgumentException
{
    protected $code = 409;
}