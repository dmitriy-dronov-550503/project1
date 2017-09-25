<?php

namespace AppBundle\Controller\users;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserListController extends Controller
{
    /**
     * @Route("/user/pgn", name="user_pagination")
     */
    public function indexAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:User a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('users/userList.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Route("/user/get", name="user_get")
     */
    public function getUsersAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if($request->request->get('sort') && $request->request->get('direction')){
            $qb = $em->createQueryBuilder();
            $qb->select('a')
                ->from('AppBundle:User', 'a')
                ->orderBy($request->request->get('sort'), $request->request->get('direction'));

            $query = $qb->getQuery();
        }
        else {
            $dql   = "SELECT a FROM AppBundle:User a";
            $query = $em->createQuery($dql);
        }


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', $request->request->get('page'))/*page number*/,
            10/*limit per page*/
        );

        // parameters to template
        return $this->render('users/userPaginationRender.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Route("/users/delete", name="delete")
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(User::class);
        if ($request->request->has('delete')) {
            $deleteUsers = $request->get('checkedUsers');
            if($deleteUsers!=null) {
                foreach ($deleteUsers as $deleteUser) {
                    $user = $repository->findOneById($deleteUser);
                    if ($user->getRole() != 'ROLE_ADMIN') $em->remove($user);
                }
                $em->flush();
            }
        }
        if ($request->request->has('block')) {
            $blockUsers = $repository->findById($request->get('checkedUsers'));
            foreach($blockUsers as $blockUser) {
                if($blockUser->getRole()!='ROLE_ADMIN') {
                    $blockUser->setIsActive(false);
                    $em->persist($blockUser);
                }
            }
            $em->flush();
        }
        if ($request->request->has('unblock')) {
            $blockUsers = $repository->findById($request->get('checkedUsers'));
            foreach($blockUsers as $blockUser) {
                if($blockUser->getRole()!='ROLE_ADMIN') {
                    $blockUser->setIsActive(true);
                    $em->persist($blockUser);
                }
            }
            $em->flush();
        }
        if ($request->request->has('moderator')) {
            $blockUsers = $repository->findById($request->get('checkedUsers'));
            foreach($blockUsers as $blockUser) {
                if($blockUser->getRole()!='ROLE_ADMIN') {
                    $blockUser->setRole('ROLE_EDITOR');
                    $em->persist($blockUser);
                }
            }
            $em->flush();
        }
        if ($request->request->has('unmoderator')) {
            $blockUsers = $repository->findById($request->get('checkedUsers'));
            foreach($blockUsers as $blockUser) {
                if($blockUser->getRole()!='ROLE_ADMIN') {
                    $blockUser->setRole('ROLE_USER');
                    $em->persist($blockUser);
                }
            }
            $em->flush();
        }

        return $this->redirectToRoute('user_pagination');
    }
}