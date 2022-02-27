<?php


namespace App\Http\Controllers;

use App\Commands\RegisterUser;
use App\Models\UserModel;
use App\Services\FirebaseJSONWebTokenGenerator;
use App\Services\Md5UserPasswordEncryptionService;
use App\Services\TimeAndMd5BasedUniqueIdentifierGenerator;
use Exception;
use Github\Application\EmailFormatValidatingUserRegistrationHandler;
use Github\Application\PasswordLengthValidatingUserRegistrationHandler;
use Github\Application\UserRegistrationHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ReflectionException;

/**
 * Class RegistrationController
 * @package App\Http\Controllers
 */
class RegistrationController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     * @throws ReflectionException
     */
    public function createAction(Request $request): Response
    {
        try {
            $id = (new TimeAndMd5BasedUniqueIdentifierGenerator())->generate('user-');
            $email = $request->get('email') ?? '';
            $password = $request->get('password') ?? '';
            $passwordConfirmation = $request->get('passwordConfirmation') ?? '';

            $registerUserCommand = (new RegisterUser($id, $email, $password))
                ->withPasswordConfirmation($passwordConfirmation);

            $userRepository = new UserModel();
            $passwordEncryptionService = new Md5UserPasswordEncryptionService();
            $registerUserCommandHandler = new UserRegistrationHandler($userRepository, $passwordEncryptionService);
            $emailFormatValidatingUserRegistrationHandler = new EmailFormatValidatingUserRegistrationHandler(
                $registerUserCommandHandler
            );
            $passwordLengthValidatingUserRegistrationHandler = new PasswordLengthValidatingUserRegistrationHandler(
                $emailFormatValidatingUserRegistrationHandler,
                8
            );

            $passwordLengthValidatingUserRegistrationHandler->handleThis($registerUserCommand);

            $issuer = env('JWT_ISSUER');
            $accessTokenLifeInSeconds = env('JWT_TOKEN_LIFETIME');
            $secretKey = env('JWT_SECRET_KEY');
            $timeIssued = time();
            $expiresOn = $timeIssued + $accessTokenLifeInSeconds;
            $payload = [
                'sub' => $id,
                'email' => $email,
                'iss' => $issuer,
                'iat' => $timeIssued,
                'exp' => $expiresOn
            ];

            $jwtGenerator = new FirebaseJSONWebTokenGenerator($secretKey);
            $accessToken = $jwtGenerator->generate($payload);
            $tokenType = 'bearer';
            $expiresIn = $timeIssued + $accessTokenLifeInSeconds;

            $response = [
                'id' => $id,
                'accessToken' => $accessToken,
                'tokenType' => $tokenType,
                'expiresIn' => $expiresIn,
            ];
            return \response($response, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->exception($exception);
        }
    }
}