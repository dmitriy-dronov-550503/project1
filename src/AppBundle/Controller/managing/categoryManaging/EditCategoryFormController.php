<?php

use AppBundle\Entity\Category;
use AppBundle\Form\EditCategoryType;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditCategoryFormController extends Controller
{
    /**
     * @Route("/edit_category", name="edit_category")
     */
    public function registerAction(Request $request)
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
            'managing/categoryManaging/editCategoryForm',
            array('form' => $form->createView())
        );
    }
}