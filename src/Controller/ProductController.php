<?php

namespace App\Controller;

use App\Service\Sluggify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/products', name: 'app_products')]
    public function listProducts(): Response {
        return $this->render('product/products.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/products/{id}')]
    public function viewProduct(int $id, Sluggify $slugger): Response {
        $slug = $slugger->generate('ééééé');
        return $this->render('product/product.html.twig', [
            'controller_name' => 'ProductController',
            'id' => $id,
            'slug' => $slug
        ]);
    }
}
