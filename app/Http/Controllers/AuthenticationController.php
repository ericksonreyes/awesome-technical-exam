<?php


namespace App\Http\Controllers;

use App\Commands\AuthenticateUserCommand;
use App\Repository\FirebaseJSONWebTokenGenerator;
use App\Repository\UserRepository;
use App\Services\Md5UserPasswordEncryptionService;
use Exception;
use Github\Application\UserAuthenticationHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ReflectionException;

/**
 * Class AuthenticationController
 * @package App\Http\Controllers
 */
class AuthenticationController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     * @throws ReflectionException
     */
    public function createAction(Request $request): Response
    {
        try {
            $username = $request->get('username') ?? '';
            $password = $request->get('password') ?? '';

            $authenticateUserCommand = new AuthenticateUserCommand($username, $password);

            $userRepository = new UserRepository();
            $passwordEncryptionService = new Md5UserPasswordEncryptionService();
            $userAuthenticationHandler = new UserAuthenticationHandler($userRepository, $passwordEncryptionService);
            $userAuthenticationHandler->handleThis($authenticateUserCommand);

            $issuer = env('JWT_ISSUER');
            $accessTokenLifeInSeconds = env('JWT_TOKEN_LIFETIME');
            $secretKey = env('JWT_SECRET_KEY');
            $timeIssued = time();
            $expiresOn = $timeIssued + $accessTokenLifeInSeconds;
            $payload = [
                'sub' => $userRepository->findOneByUsername($username)->id(),
                'username' => $username,
                'iss' => $issuer,
                'iat' => $timeIssued,
                'exp' => $expiresOn
            ];

            $jwtGenerator = new FirebaseJSONWebTokenGenerator($secretKey);
            $accessToken = $jwtGenerator->generate($payload);
            $tokenType = 'bearer';
            $expiresIn = $timeIssued + $accessTokenLifeInSeconds;

            $response = [
                'accessToken' => $accessToken,
                'tokenType' => $tokenType,
                'expiresIn' => $expiresIn,
            ];
            return \response($response, Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->exception($exception);
        }
    }
}