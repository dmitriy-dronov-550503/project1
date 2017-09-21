<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesListController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);

        // replace this example code with whatever you need
        return $this->render(
            'catalog/categoriesList.html.twig',
            array('categories' => $repository->findByName("Categories"))
        );
    }
}