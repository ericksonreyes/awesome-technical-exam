<?php


namespace App\Repository;


use Github\Domain\Model\GitlabUserInterface;
use Github\Domain\Repository\GitlabUserRepository as DomainGitlabUserRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;

/**
 * Class GitlabUserRepository
 * @package App\Repository
 */
class GuzzleGitlabUserRepository implements DomainGitlabUserRepository
{

    /**
     * @var Client
     */
    private $guzzle;

    public function __construct()
    {
        $this->guzzle = new Client();
    }

    /**
     * @param array $userNames
     * @return GitlabUserInterface[]
     * @throws GuzzleException
     */
    public function findByUserNames(array $userNames): array
    {
        $gitlabUsers = [];
        foreach ($userNames as $userName) {
            $response = $this->guzzle->get("https://api.github.com/users/{$userName}");
            if ($response->getStatusCode() === Response::HTTP_OK) {
                $body = json_decode($response->getBody(), true);
                $gitlabUsers[$body['login']] = (new GitlabUser())
                    ->setId($body['id'])
                    ->setLogin($body['login'])
                    ->setName($body['name'] ?? '')
                    ->setCompany($body['company'] ?? '')
                    ->setNumberOfFollowers($body['followers'])
                    ->setNumberOfPublicRepositories($body['public_repos'])
                ;
            }
        }
        ksort($gitlabUsers);
        return $gitlabUsers;
    }
}