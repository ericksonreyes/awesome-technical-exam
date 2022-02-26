<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class JSONFormattedHandler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $code = (new ReflectionClass($exception))->getShortName();
        $httpCode = $exception->getCode() >= 100 && $exception->getCode() < 600 ? $exception->getCode() : 500;
        $message = trim($exception->getMessage()) !== '' ? $exception->getMessage() : $code;

        if (env('APP_DEBUG')) {
            return \response(
                [
                    '_error' => [
                        'code' => $code,
                        'message' => $message,
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                    ]
                ],
                $httpCode,
                [
                    'Cache-Control' => 'no-store'
                ]
            );
        }

        return \response(
            [
                '_error' => [
                    'code' => $code,
                    'message' => $exception->getMessage()
                ]
            ],
            $httpCode,
            [
                'Cache-Control' => 'no-store'
            ]
        );
    }
}
