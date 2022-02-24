<?php

namespace App\Http\Controllers;

use Exception;
use Github\Domain\Model\Exception\DuplicateUsernameException;
use Illuminate\Http\Response;
use ReflectionException;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * @return Response
     * @throws ReflectionException
     */
    public function indexAction(): Response {
        try {
            $response = [
                'message' => 'Welcome to my awesome technical exam',
                'phpVersion' => phpversion(),
                'lastModifiedOn' => date('c', filemtime(__FILE__)),
                '_links' => [
                    'self' => [
                        'title' => 'Awesome technical exam',
                        'href' => url()
                    ]
                ]
            ];
            return \response($response, Response::HTTP_OK);
        }
        catch (Exception $exception) {
            return $this->exception($exception);
        }
    }
}
