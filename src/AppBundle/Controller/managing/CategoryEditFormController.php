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
     * @Route("/category_create", name="category_create")
     */
    public function categoryCreateAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(EditCategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('categories');
        }

        return $this->render(
            'managing/categoryEditForm.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/category_edit/{id}", name="category_edit2", requirements={"id": "\d+"})
     */
    public function categoryEditAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if(!$category) {
            throw $this->createNotFoundException('Not found Category with id: ' . $id);
        }

        $form = $this->createForm(EditCategoryType::class, $category, array('categoryId' => $id));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('categories');
        }

        return $this->render(
            'managing/categoryEditForm.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/category_delete/{id}", name="category_delete2", requirements={"id": "\d+"})
     */
    public function categoryDeleteAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('categories');
    }

}