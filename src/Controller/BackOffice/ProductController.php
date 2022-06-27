<?php

namespace App\Controller\BackOffice;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\MonthRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="back_office_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository, MonthRepository $monthRepository): Response
    {
        
        // dd($productRepository->findAll());

        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
            'months' => $monthRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="back_office_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);
            // dd($form);
            return $this->redirectToRoute('back_office_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_office_product_show", methods={"GET"})
     */
    public function show(Product $product, MonthRepository $monthRepository): Response
    {
        
        // dd($product->getMonths(7));
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'months' => $monthRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="back_office_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);

            return $this->redirectToRoute('back_office_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="back_office_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('back_office_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
