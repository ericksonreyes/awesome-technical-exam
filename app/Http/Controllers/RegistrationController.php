<?php


namespace App\Http\Controllers;

use App\Commands\RegisterUser;
use App\Repository\UserRepository;
use App\Services\TimeAndMd5BasedUniqueIdentifierGenerator;
use Exception;
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
            $username = $request->get('email') ?? '';
            $password = $request->get('password') ?? '';
            $passwordConfirmation = $request->get('passwordConfirmation') ?? '';

            $registerUserCommand = (new RegisterUser($id, $username, $password))
                ->withPasswordConfirmation($passwordConfirmation);

            $userRepository = new UserRepository();
            $registerUserCommandHandler = new UserRegistrationHandler($userRepository);
            $registerUserCommandHandler->handleThis($registerUserCommand);

            $accessTokenLifeInSeconds = env('ACCESS_TOKEN_LIFETIME');
            $accessToken = '';
            $tokenType = 'Bearer';
            $expiresIn = time() + $accessTokenLifeInSeconds;

            $response = [
                'id' => $id,
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