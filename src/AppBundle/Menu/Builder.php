<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'homepage'));

        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $blog = $this->container->get('doctrine')->getRepository('AppBundle:Product')->findAll();



        // create another menu item
        $menu->addChild('Home', array('route' => 'homepage'));
        $menu->addChild('Product list', array('route' => 'products'));
        $menu->addChild('Sign in', array('route' => 'login'));
        $menu->addChild('Sign up', array('route' => 'register'));
        $menu->addChild('Managing', array('route' => 'categories'));
        // you can also add sub level's to your menu's as follows
        $menu['Managing']->addChild('Manage categories', array('route' => 'categories'));
        $menu['Managing']->addChild('Manage users', array('route' => 'user_list'));

        // ... add more children

        return $menu;
    }
}