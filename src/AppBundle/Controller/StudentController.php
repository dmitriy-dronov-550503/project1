<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28.08.2017
 * Time: 17:49
 */

use AppBundle\Entity\Human;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class StudentController extends Controller
{
    public function CreateAction(Request $request)
    {
        $human = new Human();
        $human->setName();
        $human->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($human)
            ->add('Name', TextType::class)
            ->add('Surname', TextType::class)
            ->add('Patronymic', TextType::class)
            ->add('Faculty', TextType::class)
            ->add('Create', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}