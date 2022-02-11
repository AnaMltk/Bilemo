<?php

namespace App\Controller;

use App\Representation\Users;
use OpenApi\Annotations as OA;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
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
     */
    public function getUserList(Request $request, UserRepository $userRepository, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $users = $userRepository->findBy([], ['name' => 'ASC'], $limit, $offset);
        return new Users($users);
    }

    /**
     *@Route("/api/client/{id}/users/{user_id}", methods={"GET"})
     *@OA\Tag(name="User")
     */
    public function getUserDetails(Request $request, ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);
        return $this->respond($product);
    }

    public function addUser()
    {

    }

    public function deleteUser()
    {

    }
}