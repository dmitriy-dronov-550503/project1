<?php

namespace AppBundle\Controller\managing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductEditFormController extends Controller
{
    /**
     * @Route("/product_edit", name="product_edit")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('managing/productManaging/editProductForm.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}