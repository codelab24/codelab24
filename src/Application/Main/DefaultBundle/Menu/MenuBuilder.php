<?php
/**
 * Touchwire Software 2010-2020
 * User: developer
 * Date: 4/8/13
 * Time: 3:30 PM
 * File: MenuBuilder.php
 */

namespace Application\Main\DefaultBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{
    //main items
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        $menu->addChild('item 1', array('route' => 'index'))
            ->setAttribute('icon', 'icon-list');

        $menu->addChild('item 2', array('route' => 'about'))
            ->setAttribute('icon', 'icon-group');

        return $menu;
    }

    //user prefs
    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        /*
        You probably want to show user specific information such as the username here. That's possible! Use any of the below methods to do this.

        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {} // Check if the visitor has any authenticated roles
        $username = $this->container->get('security.context')->getToken()->getUser()->getUsername(); // Get username of the current logged in user

        */
        $menu->addChild('User', array('label' => 'Hi visitor'))
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'icon-user');

        $menu['User']->addChild('Edit profile', array('route' => 'contact'))
            ->setAttribute('icon', 'icon-edit');

        return $menu;
    }
}

