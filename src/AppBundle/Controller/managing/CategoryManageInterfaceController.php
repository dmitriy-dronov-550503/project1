<?php

namespace AppBundle\Controller\managing;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryManageInterfaceController
 * @package AppBundle\Controller\managing
 * Interface to change connections between categories
 */
class  CategoryManageInterfaceController extends Controller
{
    /**
     * @Route("/category_manage", name="category_manage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        // replace this example code with whatever you need
        return $this->render(
            'managing/categoryManageInterface.html.twig',
            array('categories' => $repository->findByName("Categories"))
        );
    }
}