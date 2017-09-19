<?php

namespace AppBundle\Controller\catalog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductListController extends Controller
{
    /**
     * @Route("/product_list", name="product_list")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('catalog/productList.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function updateDataAction(){
        $request = $this->container->get('request');
        $data1 = $request->query->get('data1');
        $data2 = $request->query->get('data2');

        //handle data

        //prepare the response, e.g.
        $response = array("code" => 100, "success" => true);
        //you can return result as JSON
        return new Response(json_encode($response));
    }
}