<?php

namespace AppBundle\Controller\managing\productManaging;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductManageInterfaceController extends Controller
{
    /**
     * @Route("/product_manage", name="product_manage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('managing/productManaging/productManageInterface.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}