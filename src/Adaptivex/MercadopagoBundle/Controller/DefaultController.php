<?php

namespace Adaptivex\MercadopagoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        //$this->get('app.mercadopago')->
        return $this->render('AdaptivexMercadopagoBundle:Default:index.html.twig');
    }
}
