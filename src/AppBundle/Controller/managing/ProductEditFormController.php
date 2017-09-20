<?php

namespace AppBundle\Controller\managing;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductEditFormController
 * @package AppBundle\Controller\managing
 * Form to edit product
 */
class ProductEditFormController extends Controller
{
    /**
     * @Route("/product_edit", name="product_edit")
     */
    public function productEditAction(Request $request, $productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);
        $product = new Product();
        if (!$product) {
            $product = new Product();
        }

        $form = $this->createEditForm($request, $product);
        $this->saveChangesToDb($product);


        return $this->render(
            'managing/productEditForm.html.twig',
            array('form' => $form->createView())
        );
    }

    private function createEditForm(Request $request, Product $product)
    {
        $form = $this->createForm(UserType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // there should be redirect to this product page in future:
            return $this->redirectToRoute('products');
        }
        return $form;
    }

    private function saveChangesToDb($product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
    }

}