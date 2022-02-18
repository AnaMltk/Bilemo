<?php

namespace App\Controller;

use App\Entity\User;
use App\Representation\Users;
use OpenApi\Annotations as OA;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Exception\ForbiddenException;
use App\Repository\ProductRepository;
use Exception;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\AbstractFOSRestController;

class ClientController extends AbstractFOSRestController
{
    /**
     *@Route("/api/client/{id}/users", methods={"GET"})
     *@throws ForbiddenException
     *@QueryParam(
     *   name="offset",
     *   requirements="\d+",
     *   default="0",
     *   description="offset"
     *)
     *@QueryParam(
     *   name="limit",
     *   requirements="\d+",
     *   default="10",
     *   description="limit"
     *)
     *@View(serializergroups={"list_user"})
     *@OA\Tag(name="User")
     *@Security(name="Bearer")
     *@OA\Parameter(
     *   name="offset",
     *   in="query",
     *   @OA\Schema(type="integer")
     *)
     *@OA\Parameter(
     *   name="limit",
     *   in="query",
     *   @OA\Schema(type="integer")
     *)
     *@OA\Response(
     *    response=200, 
     *    description="User list",
     *    @OA\JsonContent(
     *      type="array",
     *      @OA\Items(ref=@Model(type=User::class, groups={"list_user"}))
     *    )
     *)
     *@OA\Response(
     *response=401,
     *description="Invalid token"
     *)
     *@OA\Response(
     *response=403,
     *description="Access forbidden"
     *)
     */
    public function getUserList(Request $request, UserRepository $userRepository, ClientRepository $clientRepository, ParamFetcherInterface $paramFetcher, $id)
    {
        $client = $clientRepository->find($id);
        if($this->getUser()->getId() !== $client->getId()){
            throw new ForbiddenException('wrong user');
        }
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        
        $users = $userRepository->findByClient($client->getId(), ['email' => 'ASC'], $limit, $offset);
        
        if(!$users){
            throw new Exception('No users found');
        }
        return new Users($users);
    }

    /**
     *@Route("/api/client/{id}/users/{user_id}", methods={"GET"})
     *@OA\Tag(name="User")
     */
    public function getUserDetails(Request $request, ProductRepository $productRepository, $id)
    {
        $user = $productRepository->find($id);
        return $this->respond($user);
    }

    /**
     *@Route("/api/client/{id}/users", methods={"POST"})
     *@OA\Tag(name="User")
     *@Security(name="Bearer")
     *@QueryParam(
     *   name="first_name",
     *   default="",
     *   description="first name"
     *)
     *@QueryParam(
     *   name="last_name",
     *   default="",
     *   description="last name"
     *)
     *@QueryParam(
     *   name="email",
     *   default="",
     *   description="email"
     *)
     */
    public function addUser(Request $request, ClientRepository $clientRepository, ParamFetcherInterface $paramFetcher, $id)
    {
        $client = $clientRepository->find($id);
        $firstName = $paramFetcher->get('first_name');
        $lastName = $paramFetcher->get('last_name');
        $email = $paramFetcher->get('email');
        $user = new User();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setClient($client);
        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return $this->respond($user);
    }

    /**
     *@Route("/api/client/{id}/users/{user_id}", methods={"DELETE"})
     *@OA\Tag(name="User")
     *@Security(name="Bearer")
     */
    public function deleteUser(UserRepository $userRepository, $id, $user_id)
    {
        $user = $userRepository->find($user_id);
        $this->getDoctrine()->getManager()->remove($user);
        return $this->respond($user);
    }
    protected function respond($data, int $statusCode = Response::HTTP_OK): Response
    {
        return $this->handleView($this->view($data, $statusCode));
    }
}
