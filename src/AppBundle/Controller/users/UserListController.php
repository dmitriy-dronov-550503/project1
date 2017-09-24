<?php

namespace AppBundle\Controller\users;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserListController extends Controller
{
    /**
     * @Route("/user_list", name="user_list")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        // replace this example code with whatever you need
        return $this->render('users/userList.html.twig', [
            'users' => $repository->findAll()
        ]);
    }
}