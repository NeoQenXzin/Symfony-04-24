<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
 
    
    //   private   $products = [
        private static array  $products = [
            [
              'id' => 1,
              'name' => 'Iphone 13',
              'price' => 999.99,
              'description' => 'Apple iPhone 13 Pro 256 Go Bleu Pacifique',
              'category' => 'smartphone',
            ],
            [
              'id' => 2,
              'name' => 'Samsung Galaxy S21',
              'price' => 899.99,
              'description' => 'Samsung Galaxy S21 5G 128 Go Double SIM Noir Phantom',
              'category' => 'smartphone',
            ],
            [
              'id' => 3,
              'name' => 'Huawei P40',
              'price' => 799.99,
              'description' => 'Huawei P40 Pro 5G 256 Go Double SIM Noir',
              'category' => 'smartphone',
            ],
            [
              'id' => 4,
              'name' => 'MacBook Pro',
              'price' => 1299.99,
              'description' => 'Apple MacBook Pro 13" 256 Go SSD 8 Go RAM Intel Core i5 quadricœur à 1,4 GHz Argent',
              'category' => 'laptop',
            ]
            ];
    
#[Route('/products', name: 'products', methods: ['GET'])]
    public function index(): JsonResponse
    {
        // return $this->json($this->products);

        return $this->json(self::$products);
        // return $this->json([
        //     'data' => $this->products
        // ]);
    }
    #[Route('/product/{id}', name: 'product', methods: ['GET'])]
    public function product(int $id): JsonResponse
    {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return $this->json($product);
                return $this->json($product);
            }
        }

       
        
        return $this->json(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
    }
}
