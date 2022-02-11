<?php

namespace App\Controller;

use App\Entity\Product;
use OpenApi\Annotations as OA;
use App\Representation\Products;
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
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class ProductController extends AbstractFOSRestController
{
    /**
     *@Route("/api/products", methods={"GET"})
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
     *@View(serializergroups={"list_product"})
     *@OA\Tag(name="Product")
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
     *    description="Product list",
     *    @OA\JsonContent(
     *      type="array",
     *      @OA\Items(ref=@Model(type=Product::class, groups={"list_product"}))
     *    )
     *)
     *@OA\Response(
     *response=401,
     *description="Invalid token"
     *)
     */
    public function getProductList(Request $request, ProductRepository $productRepository, ParamFetcherInterface $paramFetcher, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $products = $productRepository->findBy([], ['name' => 'ASC'], $limit, $offset);
        return new Products($products);
        //return $this->respond($products);
    }

    /**
     *@Route("/api/products/{id}", methods={"GET"})
     *@OA\Tag(name="Product")
     */
    public function getProductDetails(Request $request, ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);
        return $this->respond($product);
    }

    protected function respond($data, int $statusCode = Response::HTTP_OK): Response
    {
        return $this->handleView($this->view($data, $statusCode));
    }
}
