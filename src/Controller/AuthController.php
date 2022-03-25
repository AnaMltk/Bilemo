<?php

namespace App\Controller;

use Exception;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class AuthController extends AbstractFOSRestController
{
    /**
     * @Route("/api/login", methods={"POST"})
     * Create a client with a default Authorization header.
     * @OA\Tag(name="Security")
     * @OA\RequestBody(
     *  required=true,
     *  @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *          @OA\Property(property="email", type="string", example="admin@orange.com"),
     *          @OA\Property(property="password", type="string", example="admin")
     *      )
     *  )
     * )
     * @OA\Response(
     *    response=200,
     *    description="Token",
     *    @OA\JsonContent(
     *      @OA\Property(
     *         property="token", type="string"
     *      )
     *    )
     *)
     *@OA\Response(
     *  response=401,
     *  description="Invalid credentials"
     *)
     *
     */
    public function login()
    {
        throw new Exception('bad login');
    }
    /*public function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                '_username' => $username,
                '_password' => $password,
            ))
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }*/
}
