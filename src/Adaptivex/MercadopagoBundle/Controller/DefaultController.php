<?php

namespace Adaptivex\MercadopagoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        
        return $this->render('AdaptivexMercadopagoBundle:Default:index.html.twig');
    }
}
