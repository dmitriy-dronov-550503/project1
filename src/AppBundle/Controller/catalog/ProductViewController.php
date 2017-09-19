<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductViewController extends Controller
{
    /**
     * @Route("/product_view", name="product_view")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        // replace this example code with whatever you need
        return $this->render(
            'catalog/productView.html.twig'
            );
    }
}