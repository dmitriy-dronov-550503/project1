<?php

namespace AppBundle\Controller\managing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class  CategoryManageInterfaceController extends Controller
{
    /**
     * @Route("/category_manage", name="category_manage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('managing/categoryManaging/categoryManageInterface.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}