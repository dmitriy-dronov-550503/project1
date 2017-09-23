<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 23.09.17
 * Time: 15:22
 */

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use function PHPSTORM_META\elementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPage extends Controller
{
    /**
     * @Route("/product_view/{id}", name="product_ajax_view", requirements={"id": "/+d"})
     */
    public function productViewAction(Request $request, $id)
    {
        //$repository = $this->getDoctrine()->getRepository(Product::class);
        // replace this example code with whatever you need
        return $this->render('catalog/productView.html.twig'
        );
    }
}