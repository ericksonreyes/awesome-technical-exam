<?php


namespace Github\Domain\Model;

/**
 * Interface UserAttributesInterface
 * @package Github\Domain\Model
 */
interface UserAttributesInterface
{

    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function email(): string;

    /**
     * @return string
     */
    public function password(): string;

    /**
     * @return string
     */
    public function accountStatus(): string;
}