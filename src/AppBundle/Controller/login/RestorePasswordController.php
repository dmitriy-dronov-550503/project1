<?php

namespace AppBundle\Controller\login;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestorePasswordController extends Controller
{
    /**
     * @Route("/restore_password", name="restore_password")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('login/restorePassword.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}