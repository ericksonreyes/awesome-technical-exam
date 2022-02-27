<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;
use ReflectionClass;
use ReflectionException;
use Throwable;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{

    /**
     * @param Exception $exception
     * @return Response
     * @throws ReflectionException
     */
    protected function exception(Exception $exception): Response
    {
        $code = (new ReflectionClass($exception))->getShortName();
        $httpCode = $this->getStatusCode($exception);
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

    /**
     * @param Throwable $exception
     * @return int
     */
    private function getStatusCode(Throwable $exception): int {
        if (is_integer($exception->getCode()) === false) {
            return 500;
        }
        return $exception->getCode() >= 100 && $exception->getCode() < 600 ? $exception->getCode() : 500;
    }
}
