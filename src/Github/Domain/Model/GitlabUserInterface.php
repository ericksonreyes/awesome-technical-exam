<?php


namespace Github\Domain\Model;

/**
 * Interface GitlabUserInterface
 * @package Github\Domain\Model
 */
interface GitlabUserInterface
{
    /**
     * @return int
     */
    public function id(): int;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function company(): string;

    /**
     * @return int
     */
    public function numberOfFollowers(): int;

    /**
     * @return int
     */
    public function numberOfPublicRepositories(): int;

    /**
     * @return int
     */
    public function avgNumberOfFollowersPerRepository(): int;
}