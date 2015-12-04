<?php

namespace Valonde\EgleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ValondeEgleBundle:Default:index.html.twig');
    }
}
