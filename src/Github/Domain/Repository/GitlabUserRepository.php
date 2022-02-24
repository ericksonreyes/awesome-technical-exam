<?php


namespace Github\Domain\Repository;


use Github\Domain\Model\GitlabUserInterface;

/**
 * Interface GitlabUserRepository
 * @package Github\Domain\Repository
 */
interface GitlabUserRepository
{

    /**
     * @param array $userNames
     * @return GitlabUserInterface[]
     */
    public function findByUserNames(array $userNames): array;
}