<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use function PHPSTORM_META\elementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductViewController extends Controller
{

    /**
     * @Route("/product_view", name="product_ajax_view")
     */
    public function productViewAction(Request $request)
    {
        //$repository = $this->getDoctrine()->getRepository(Product::class);
        // replace this example code with whatever you need
        return $this->render('catalog/productView.html.twig'
        );
    }

    /**
     * @Route("product_view/action", name="product_view_action")
     */
    public function dataAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $data = $request->request->get('data_1');
        $product = $repository->findOneByName($data);
        if ($product) {
            $response = new Response(
                'Вы ввели:' . $data . '
            <h1>'.$product->getName().'</h1>
            <h2>'.$product->getDescription().'</h2>'
            );
        } else {
            $response = new Response(
                'Вы ввели:' . $data . '<p>Нет такого продукта</p>'
            );
        }
        return $response;
    }

    /**
     * @Route("/product_view/{id}", name="product_view")
     */
    public function productViewIdAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        return new Response(
            '<h1>Product view by id: ' . $id . '</h1>
                    <h2>' . $product->getName() . '</h2>
                    <h3>' . $product->getDescription() . '</h3>'
        );
    }
}