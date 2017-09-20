<?php

namespace AppBundle\Controller\managing;

use AppBundle\Entity\Category;
use AppBundle\Form\EditCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryEditFormController
 * @package AppBundle\Controller\managing
 * Form to edit category
 */
class CategoryEditFormController extends Controller
{
    /**
     * @Route("/category_edit", name="category_edit")
     */
    public function categoryEditAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(EditCategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'managing/categoryEditForm.html.twig',
            array('form' => $form->createView())
        );
    }
}