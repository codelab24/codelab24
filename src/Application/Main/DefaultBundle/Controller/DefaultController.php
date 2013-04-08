<?php

namespace Application\Main\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/about", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route("/contact", name="contact")
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }

    /**
     * @Route("/support", name="support")
     * @Template()
     */
    public function supportAction()
    {
        return array();
    }
}
