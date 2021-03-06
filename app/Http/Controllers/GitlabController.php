<?php


namespace App\Http\Controllers;

use App\Repository\GuzzleGitlabUserRepository;
use App\Repository\RedisCachedGitlabUserRepository;
use App\Services\EloquentAwareSearchHistoryService;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ReflectionException;

/**
 * Class GitlabController
 * @package App\Http\Controllers
 */
class GitlabController extends Controller
{

    const MAXIMUM_NUMBER_OF_USERNAME_KEYWORDS = 10;
    /**
     * @param Request $request
     * @return Response
     * @throws ReflectionException
     */
    public function indexAction(Request $request): Response
    {
        try {
            $users = [];
            if ($request->has('username')) {
                $searchString = trim($request->get('username'));
                $userNames = [];
                if ($searchString !== '') {
                    $usernameArray = explode(',', $searchString);
                    $userNames = array_map(function(string $username) {
                        return trim($username);
                    }, $usernameArray);
                    $userNames = array_slice($userNames, 0, self::MAXIMUM_NUMBER_OF_USERNAME_KEYWORDS);
                }

                $gitlabUserRepository = new GuzzleGitlabUserRepository();
                $cachedGitlabUserRepository = new RedisCachedGitlabUserRepository(
                    $gitlabUserRepository,
                    env('REDIS_HOST'),
                    env('REDIS_CACHE_LIFETIME_IN_SECONDS')
                );
                $searchHistoryService = new EloquentAwareSearchHistoryService();

                $searchStartTime = microtime(true);
                $gitlabUsers = $cachedGitlabUserRepository->findByUserNames($userNames);

                $email = $request->get('accessTokenPayload')['email'];
                $resultCount = count($gitlabUsers);
                $searchedOn = new DateTimeImmutable();
                $searchSpeed = microtime(true) - $searchStartTime;
                $searchHistoryService->record($email,$searchString, $searchedOn, $resultCount, $searchSpeed);

                foreach ($gitlabUsers as $gitlabUser) {
                    $users[] = [
                        'id' => $gitlabUser->id(),
                        'login' => $gitlabUser->login(),
                        'name' => $gitlabUser->name(),
                        'company' => $gitlabUser->company(),
                        'followers' => $gitlabUser->numberOfFollowers(),
                        'public_repository_count' => $gitlabUser->numberOfPublicRepositories(),
                        'average_number_of_public_repository_followers' =>
                            $gitlabUser->averageNumberOfFollowersPerRepository(),
                        'origin_repository' => $gitlabUser->sourceRepository()
                    ];
                }
            }

            $response = [
                '_embedded' => [
                    'users' => $users
                ]
            ];
            return \response($response, Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->exception($exception);
        }
    }
}