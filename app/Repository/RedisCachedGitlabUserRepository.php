<?php


namespace App\Repository;

use Github\Domain\Model\GitlabUserInterface;
use Github\Domain\Repository\GitlabUserRepository;
use Predis\Client;

/**
 * Class RedisCachedGitlabUserRepository
 * @package App\Repository
 */
class RedisCachedGitlabUserRepository implements GitlabUserRepository
{

    /**
     * @var Client
     */
    private $client;

    private $expiresInSeconds;

    /**
     * @var GitlabUserRepository
     */
    private $gitlabUserRepository;

    /**
     * RedisCachedGitlabUserRepository constructor.
     * @param GitlabUserRepository $gitlabUserRepository
     * @param string $redisHost
     * @param int $expiresInSeconds
     */
    public function __construct(GitlabUserRepository $gitlabUserRepository, string $redisHost, int $expiresInSeconds)
    {
        $this->client = new Client(['host' => $redisHost]);
        $this->gitlabUserRepository = $gitlabUserRepository;
        $this->expiresInSeconds=$expiresInSeconds;
    }


    /**
     * @param array $userNames
     * @return GitlabUserInterface[]
     */
    public function findByUserNames(array $userNames): array
    {
        /**
         * @var $gitlabUser GitlabUserInterface|GitlabUser
         * @var $unCachedGitlabUser GitlabUser
         */
        $unCachedUserNames = [];
        $gitlabUsers = [];

        foreach ($userNames as $userName) {
            $cachedGitlabUser = $this->client->get($userName);
            if ($cachedGitlabUser) {
                $gitlabUser = unserialize($cachedGitlabUser);
                $gitlabUser->setSourceRepository('Cache');
                $gitlabUsers[$gitlabUser->login()] = $gitlabUser;
                continue;
            }
            $unCachedUserNames[] = $userName;
        }

        $unCachedGitlabUsers = $this->gitlabUserRepository->findByUserNames($unCachedUserNames);
        foreach ($unCachedGitlabUsers as $unCachedGitlabUser) {
            $unCachedGitlabUser->setSourceRepository('Github');
            $gitlabUsers[$unCachedGitlabUser->login()] = $unCachedGitlabUser;
            $this->store($unCachedGitlabUser);
        }

        ksort($gitlabUsers);
        return $gitlabUsers;
    }

    /**
     * @param GitlabUserInterface $gitlabUser
     */
    public function store(GitlabUserInterface $gitlabUser): void
    {
        $serializedGitlabUser = serialize($gitlabUser);
        $this->client->set(
            $gitlabUser->login(),
            $serializedGitlabUser,
            'EX',
            $this->expiresInSeconds
        );
    }
}