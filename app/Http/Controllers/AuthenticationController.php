<?php


namespace App\Http\Controllers;

use App\Commands\AuthenticateUserCommand;
use App\Models\UserModel;
use App\Services\FirebaseJSONWebTokenGenerator;
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
            $email = $request->get('email') ?? '';
            $password = $request->get('password') ?? '';

            $authenticateUserCommand = new AuthenticateUserCommand($email, $password);

            $userRepository = new UserModel();
            $passwordEncryptionService = new Md5UserPasswordEncryptionService();
            $userAuthenticationHandler = new UserAuthenticationHandler($userRepository, $passwordEncryptionService);
            $userAuthenticationHandler->handleThis($authenticateUserCommand);

            $issuer = env('JWT_ISSUER');
            $accessTokenLifeInSeconds = env('JWT_TOKEN_LIFETIME');
            $secretKey = env('JWT_SECRET_KEY');
            $encryptionMethod = env('JWT_ENCRYPTION_METHOD');
            $timeIssued = time();
            $expiresOn = $timeIssued + $accessTokenLifeInSeconds;
            $payload = [
                'sub' => $userRepository->findOneByEmail($email)->id(),
                'email' => $email,
                'iss' => $issuer,
                'iat' => $timeIssued,
                'exp' => $expiresOn
            ];

            $jwtGenerator = (new FirebaseJSONWebTokenGenerator($secretKey))->setEncryptionMethod($encryptionMethod);
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