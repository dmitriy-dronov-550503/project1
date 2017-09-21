<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductViewController
 * @package AppBundle\Controller\catalog
 * Page of one product
 */
class ProductViewController extends Controller
{
    // there should be uniq URLs for each product in Rout
    /**
     * @Route("/product/{productId}", name="product_view")
     */
    public function indexAction(Request $request, $productId)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        // replace this example code with whatever you need
        return $this->render(
            'catalog/productView.html.twig'
            );
    }
}