<?php

namespace App\Controller\Api\V1;

use App\Entity\Category;
use App\Entity\Month;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class that manages ressources of type Candidate
 * 
 * @Route("/api/v1", name="api_v1_")
 */
class ProductController extends AbstractController
{
  /**
   * Method to have all products
   *
   * @Route("/products", name="products", methods={"GET"})
   * 
   * @param ProductRepository $productRepository
   * @return JsonResponse
   */
  public function productsGetCollection(ProductRepository $productRepository): JsonResponse
  {

    $productsList = $productRepository->findAll();

    return $this->json([
      'products' => $productsList,
      ],
      Response::HTTP_OK,
      [],
      ['groups' => 'products_get_collection']
    );
  }

  /**
   * Method to have a product whose {id} is given
   *    
   * @Route("/products/{id}", name="product_get_detail", methods={"GET"}, requirements={"id"="\d+"}) 
   *
   * @param Product|null $product
   * @return JsonResponse
   */
  public function productGetDetails(Product $product = null): JsonResponse
  {

    // 404 ?
    if ($product === null){
      // Returns an error 404 if the product is unknown
      return $this->json(['error' => 'Produit non trouvé.'], Response::HTTP_NOT_FOUND);
    }

    return $this->json(
      $product,
      Response::HTTP_OK,
      [],
      ['groups' => 'product_get_item']
    );
  }

  /**
   * Method to have all products whose {category} is given
   *
   * @Route("/products/category/{id}", name="products_by_category", methods={"GET"}) 
   * 
   * @return JsonResponse
   */
  public function productsGetCollectionByCategory(Category $category = null, ProductRepository $productRepository): JsonResponse
  {

    // 404 ?
    if ($category === null){
      // Returns an error 404 if the category is unknown
      return $this->json(['error' => 'Catégorie non trouvée.'], Response::HTTP_NOT_FOUND);
    }
    
    $productsList = $productRepository->findBy(
      ['category' => $category]
    );

    return $this->json([
      'products' => $productsList,
      ],
      Response::HTTP_OK,
      [],
      ['groups' => 'products_get_collection']
    );
  }

  /**
   * Method to have all products whose {month} is given
   *
   * @Route("/products/month/{id}", name="products_by_month", methods={"GET"}) 
   * 
   * @return JsonResponse
   */
  public function productsGetCollectionByMonth(Month $month = null, ProductRepository $productRepository): JsonResponse
  {
    
    // 404 ?
    if ($month === null){
      // Returns an error 404 if the month is unknown
      return $this->json(['error' => 'Mois non trouvé.'], Response::HTTP_NOT_FOUND);
    }    
    
    $productsList = $productRepository->findProductsOfMonth($month);

    return $this->json([
      'products' => $productsList,
      ],
      Response::HTTP_OK,
      [],
      ['groups' => 'products_get_collection']
    );
  }
}