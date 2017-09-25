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

class ProductPageController extends Controller
{
    /**
     * @Route("/{_locale}/product_page/{id}", name="product_page", requirements={"id": "\d+"})
     */
    public function productViewAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);
        return $this->render('catalog/productPage.html.twig', [
            'product' => $product,
                'attributes' => $product->getAttributes()
            ]
        );
    }
}