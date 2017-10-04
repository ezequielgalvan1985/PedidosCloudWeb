<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Pedido;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use\Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use \FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;

class PedidoController extends FOSRestController{
    
    /**
    * @Rest\Get("/api/Pedidos/{empresa_id}")
    */
    public function getPedidosAction($empresa_id){
        $empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findById($empresa_id);
        $result = $this->getDoctrine()->getRepository('AppBundle:Pedido')->findByEmpresa($empresa);
        if ($result === null) {
            $respuesta = array('code'=>'500',
                           'message'=>'No se encontraron registros',
                           'data'=>$result
                        );
        }else{
            $respuesta = array('code'=>'200',
                           'message'=>'ok',
                           'data'=>$result
                        );
        
        }
        return $respuesta;
    }

    /**
    * @Rest\Post("/api/pedido/add/{empresa_id}")
    */
    public function postPedidosAction($empresa_id, Request $request){
        $empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findById($empresa_id);
        
        //Leer Pedido
        $pedido = new Pedido();
        $pedido->setEmpresa($empresa);

        //leer json
        $content = $request->getContent();
        //parsear pedido
        
        $pedido->setUser()

        //parsear detalle
        $result = json_decode($content, true);

        if ($result == null) {
            $respuesta = array('code'=>'500',
                           'message'=>'No se encontraron registros',
                           'data'=>$result
                        );
        }else{
            $respuesta = array('code'=>'200',
                           'message'=>'ok',
                           'data'=>$result
                        );
        
        }
        return $respuesta;
    }
    
    /**
    * @Rest\Get("/api/check")
    */
    public function getCheckAction(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        return $user;
    }
}