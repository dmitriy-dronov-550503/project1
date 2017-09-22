<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            'categories' => $this->getDoctrine()->getRepository(Category::class)->findById(1)
        ]);
    }

    /**
     * @Route("/products/action", name="product_list_action")
     */
    public function listAction(Request $request) {
        $id = $request->request->get('data_1');
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->find($id);
        $categories = array($category);
        $categories = $this->getCategories($categories, $category);
        return $this->render('catalog/productListRender.html.twig', [
            'products' => $this->getDoctrine()->getRepository(Product::class)->findBy(array('category' => $categories))
        ]);
    }

    private function getCategories(array $categories, $category) {
        if($category->getChildren()){
            foreach($category->getChildren() as $child) {
                array_push($categories, $child);
                $categories = $this->getCategories($categories, $child);
            }
        }
        return $categories;
    }
}