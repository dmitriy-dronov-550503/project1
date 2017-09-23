<?php

namespace AppBundle\Controller\catalog;

use AppBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CategoriesListController
 * @package AppBundle\Controller\catalog
 * List of all categories. In form of categories tree
 */
class CategoriesListController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('catalog/categoriesList.html.twig');
    }

    /**
     * @Route("/categories/get_category_tree", name="get_category_tree")
     */
    public function getCategoryTreeAction(Request $request)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find(1);
        $categories = $this->getCategories(array(), $category);
        $json = json_encode($categories);
        $response = new Response($json);
        return $response;
    }

    private function getCategories(array $temp, $category)
    {
        if ($category->getChildren()) {
            foreach ($category->getChildren() as $child) {
                array_push($temp, array(
                    "title" => $child->getName(),
                    "key" => $child->getId(),
                    "children" => $this->getCategories(array(), $child)));
            }
        }
        return $temp;
    }

    /**
     * @Route("/categories/save", name="category_change_parent")
     */
    public function changeParentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $node = $repository->find($request->request->get('node'));
        $parent = $repository->find($request->request->get('parent'));
        if ($node->getParent() != $parent) {
            $node->setParent($parent);
            $em->persist($node);
            $em->flush();
        }
        return new Response('<h5>Node: ' . $node->getName() .
            '</h5></br><h5>Parent: ' . $parent->getName() . '</h5>');
    }

    /**
     * @Route("categories/flush", name="category_flush")
     */
    public function flushAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        if($request->request->get('save') === 'true'){
            $em->flush();
        }
        return new Response('<h5>Changes saved</h5>');
    }

    /**
     * @Route("/categories/add", name="category_add")
     */
    public function addCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $parent = $repository->find($request->request->get('parent'));
        $node = new Category();
        $node->setName($request->request->get('name'));
        $node->setParent($parent);
        $em->persist($node);
        $em->flush();
        return new Response($node->getId());
    }

    /**
     * @Route("/categories/delete", name="category_delete")
     */
    public function deleteCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $node = $repository->find($request->request->get('node'));
        if($node){
            $em->remove($node);
            $em->flush();
        }
        return new Response('OK');
    }

    /**
     * @Route("/categories/rename", name="category_rename")
     */
    public function renameCategory(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $node = $repository->find($request->request->get('node'));
        if($node->getName()!=$request->request->get('title')){
            $node->setName($request->request->get('title'));
            $em->persist($node);
            $em->flush();
        }

        return new Response('<h5>New node name: ' . $node->getName());
    }

}