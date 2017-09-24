<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cliente;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use\Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class ClienteController extends Controller{
    
    /**
     * Lists all cliente entities.
     *
     * @Route("/api/clientes", name="cliente_json")
     * @Method("GET")
     */
    public function newAction(){
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Cliente')->findById('1');
        $serializer = $this->container->get('jms_serializer');
        $restresult = $serializer->serialize($restresult, 'json');
       
        if ($restresult === null) {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        
        $data = new JsonResponse($restresult);
        return $data;
    }
    
    public function clienteSerializer(Cliente $cliente){
        
        return array('id'=>$cliente->id,
            'nombre'=>$cliente->nombre);
    }
    
}