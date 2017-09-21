<?php

namespace AppBundle\Controller\managing;

use AppBundle\Entity\Product;
use AppBundle\Form\EditProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductEditFormController extends Controller
{
    /**
     * @Route("/product_edit", name="product_edit")
     */
    public function indexAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(EditProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('managing/editProductForm.html.twig',
            array('form' => $form->createView())
        );
    }
}