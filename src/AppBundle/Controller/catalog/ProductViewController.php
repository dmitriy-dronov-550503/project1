<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductViewController extends Controller
{

    /**
     * @Route("/product_view", name="product_view")
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
    public function dataActrion(Request $request) {
        return new Response(
            'Значение переменной 1:<br/>
            <strong>'.$request->request->get('data_1').'</strong>
            <hr/>
            Значение переменной 2:<br/>
            <strong>'.$request->request->get('data_2').'</strong>'
        );
    }

    /**
     * @Route("/product_view/{id}", name="product_view")
     */
    public function productViewIdAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        return new Response(
            '<h1>Product view by id: '.$id.'</h1>
                    <h2>'.$product->getName().'</h2>
                    <h3>'.$product->getDescription().'</h3>'
        );
    }
}