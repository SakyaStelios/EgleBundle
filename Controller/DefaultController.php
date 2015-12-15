<?php

namespace Valonde\EgleBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="valonde_egle_homepage")
	 * @Method("GET")
	 */
    public function indexAction()
    {
        return $this->render('ValondeEgleBundle:Default:index.html.twig');
    }
}
