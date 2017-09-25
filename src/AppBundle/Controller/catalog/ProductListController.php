<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\Packages;
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
        return $this->render('catalog/productList.html.twig');
    }

    /**
     * @Route("/products/action", name="product_list_action")
     */
    public function listAction(Request $request)
    {
        $id = $request->request->get('data_1');
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->find($id);
        $categories = array($category);
        $categories = $this->getCategories($categories, $category);

        return $this->render('catalog/productListRender.html.twig', [
            'products' => $this->getDoctrine()->getRepository(Product::class)->findBy(array('category' => $categories)),
        ]);
    }

    private function getCategories(array $categories, $category)
    {
        if ($category->getChildren()) {
            foreach ($category->getChildren() as $child) {
                array_push($categories, $child);
                $categories = $this->getCategories($categories, $child);
            }
        }
        return $categories;
    }

    /**
     * @Route("/products/view", name="product_view_modal")
     */
    public function createViewModalAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($request->request->get('id'));
        return $this->render('catalog/productView.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/products/get_category_branch", name="get_category_branch")
     */
    public function getCategoryBranchAction(Request $request)
    {
        $id = $request->get('key');
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $json = json_encode($this->getCategoryBranch($category));
        $response = new Response($json);
        return $response;
    }

    private function getCategoryBranch($category)
    {
        $temp = array();
        if ($category->getChildren()) {
            foreach ($category->getChildren() as $child) {
                array_push($temp, array(
                    "title" => $child->getName(),
                    "key" => $child->getId(),
                    "addClass" => "customNode",
                    "isLazy" => $child->getChildren() != null ? true : false
                ));
            }
        }
        return $temp;
    }
}