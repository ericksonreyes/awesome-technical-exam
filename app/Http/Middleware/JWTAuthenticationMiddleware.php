<?php


namespace App\Http\Middleware;


use App\Services\FirebaseJSONWebTokenDecoder;
use Closure;
use Github\Domain\Model\Exception\ExpiredSessionException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

/**
 * Class JWTAuthenticationMiddleware
 * @package App\Http\Middleware
 */
class JWTAuthenticationMiddleware
{

    /**
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     * @return Response|ResponseFactory|mixed
     * @throws ExpiredSessionException
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($request->hasHeader('Authorization')) {
            [$accessToken] = sscanf($request->header('Authorization'), 'Bearer %s');
            if ($accessToken) {
                $secretKey = env('JWT_SECRET_KEY');
                $encryptionMethod = env('JWT_ENCRYPTION_METHOD');
                $decoder = (new FirebaseJSONWebTokenDecoder($secretKey))->setEncryptionMethod($encryptionMethod);
                $accessTokenPayload = $decoder->decode($accessToken);

                if (time() > (int)$accessTokenPayload['exp']) {
                    throw new ExpiredSessionException();
                }
                return $next($request->merge(['accessTokenPayload' => $accessTokenPayload]));
            }
        }

        return response(
            [
                'code' => 'MissingAuthorizationHeader',
                'message' => 'Missing Authorization Header'
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }
}