<?php


namespace App\Http\Controllers;

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

    /**
     * @param Request $request
     * @return Response
     * @throws ReflectionException
     */
    public function indexAction(Request $request): Response
    {
        try {
            if ($request->has('username'))
            $response = [
                '_embedded' => [
                    'users' => [
                        [
                            "id" => 1,
                            "login" => "octocat",
                            "name" => "monalisa octocat",
                            "email" => "monalisa.octocat@github.com",
                            "company" => "Github",
                            "followers" => 1,
                            "public_repository_count" => 1,
                            "average_number_of_public_repository_followers" => 12
                        ],
                        [
                            "id" => 2,
                            "login" => "ericksonreyes",
                            "name" => "erickson reyes",
                            "email" => "ercbluemonday@yahoo.com",
                            "company" => "Github",
                            "followers" => 1,
                            "public_repository_count" => 5,
                            "average_number_of_public_repository_followers" => 2
                        ]
                    ]
                ]
            ];
            return \response($response, Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->exception($exception);
        }
    }
}