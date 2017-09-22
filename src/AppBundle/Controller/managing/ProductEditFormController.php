<?php

namespace AppBundle\Controller\managing;

use AppBundle\Entity\Product;
use AppBundle\Form\EditProductType;
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
     * @Route("/product/edit/{productId}", name="product_edit")
     */
    public function productEditAction(Request $request, $productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);
        if (!$product) {
            throw $this->createNotFoundException('Not found Product with id: ' . $productId);
        }

        $form = $this->createForm(EditProductType::class, $product);
        $form->handleRequest($request);

        if(!$form->isValid()) echo $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setDateLastChange(new \DateTime());
            $this->saveChangesToDb($product);
            return $this->redirectToRoute('product_view', array('productId' => $product->getId()));
        }

        return $this->render(
            'managing/productEditForm.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/product_create", name="product_create")
     */
    public function createEditForm(Request $request)
    {
        $product = new Product();
        $product->setDateWasCreated(new \DateTime());
        $product->setDateLastChange(new \DateTime());

        $form = $this->createForm(EditProductType::class, $product);
        $form->handleRequest($request);

        if(!$form->isValid()) echo $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveChangesToDb($product);
            return $this->redirectToRoute('product_view', array('id' => $product->getId()));
        }

        return $this->render(
            'managing/productEditForm.html.twig',
            array('form' => $form->createView())
        );
    }

    private function saveChangesToDb($product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
    }
}