<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render(
            'product/index.html.twig',
            [
                'products' => $productRepository->findAll(),
            ]
        );
    }

    #[Route('/product/{id}', name: 'product', methods: ['GET'])]
    public function product(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
