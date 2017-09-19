<?php

namespace AppBundle\Controller\catalog;

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
     * @Route("/product_view", name="product_view")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('catalog/productView.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}