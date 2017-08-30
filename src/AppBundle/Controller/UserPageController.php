<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserPageController extends Controller
{
    /**
     * @Route("/userpage", name="user")
     */
    public function loginAction()
    {
        return $this->render('userpage.html');
    }

}