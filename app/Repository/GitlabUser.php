<?php


namespace App\Repository;


use Github\Domain\Model\GitlabUserInterface;

/**
 * Class GitlabUser
 * @package App\Repository
 */
class GitlabUser implements GitlabUserInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $company;

    /**
     * @var int
     */
    private $numberOfFollowers;

    /**
     * @var int
     */
    private $numberOfPublicRepositories;

    /**
     * @param int $id
     * @return GitlabUser
     */
    public function setId(int $id): GitlabUser
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $name
     * @return GitlabUser
     */
    public function setName(string $name): GitlabUser
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $login
     * @return GitlabUser
     */
    public function setLogin(string $login): GitlabUser
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @param string $company
     * @return GitlabUser
     */
    public function setCompany(string $company): GitlabUser
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @param int $numberOfFollowers
     * @return GitlabUser
     */
    public function setNumberOfFollowers(int $numberOfFollowers): GitlabUser
    {
        $this->numberOfFollowers = $numberOfFollowers;
        return $this;
    }

    /**
     * @param int $numberOfPublicRepositories
     * @return GitlabUser
     */
    public function setNumberOfPublicRepositories(int $numberOfPublicRepositories): GitlabUser
    {
        $this->numberOfPublicRepositories = $numberOfPublicRepositories;
        return $this;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function login(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function company(): string
    {
        return $this->company;
    }

    /**
     * @return int
     */
    public function numberOfFollowers(): int
    {
        return $this->numberOfFollowers;
    }

    /**
     * @return int
     */
    public function numberOfPublicRepositories(): int
    {
        return $this->numberOfPublicRepositories;
    }

    /**
     * @return float
     */
    public function averageNumberOfFollowersPerRepository(): float
    {
        if ($this->numberOfPublicRepositories() === 0) {
            return 0;
        }
        return ceil($this->numberOfFollowers() / $this->numberOfPublicRepositories());
    }

}