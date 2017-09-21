<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductListController
 * @package AppBundle\Controller\catalog
 * Page with list of products with filtration and sorting.
 */
class ProductListController extends Controller
{
    /**
     * @Route("/products", name="products")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('catalog/productList.html.twig', [
            'categories' => $this->getDoctrine()->getRepository(Category::class)->findById(1),
            'products' => $this->getDoctrine()->getRepository(Product::class)->findAll()
        ]);
    }
}