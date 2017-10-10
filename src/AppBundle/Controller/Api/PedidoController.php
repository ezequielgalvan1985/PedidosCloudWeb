<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Pedido;
use AppBundle\Entity\Empleado;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Cliente;


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
    * @Rest\Post("/api/pedido/add/")
    */
    public function postPedidosAction(Request $request){
        //leer json
        $content = $request->getContent();
        $code = '200'; $message='OK'; $result = "";
        //parsear detalle
        $json = json_decode($content, true);
        $em = $this->getDoctrine()->getManager();
        //Leer Pedido
        $empresa_id = $json['pedido']['empresa_id'];
        $fecha = $json['pedido']['fecha'];
        $empleado_id = $json['pedido']['empleado_id'];
        $android_id = $json['pedido']['android_id'];
        $cliente_id = $json['pedido']['cliente_id'];
      
        $empresa = $this->getDoctrine()->getRepository(Empresa::class)->find($empresa_id);
        if (!$empresa) {
            $code = '500';
            $message = 'no se encontro empresa';
        }

        $empleado = $this->getDoctrine()->getRepository(Empleado::class)->find($empleado_id);
        if(!$empleado){
            $code = '500';
            $message = 'no se encontro empleado';
        }

        $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($cliente_id);
        if(!$cliente){
            $code = '500';
            $message = 'no se encontro cliente';
        }
                
        $pedido = new Pedido();
        $pedido->setEmpresa($empresa);
        $pedido->setFecha(new \DateTime($fecha));
        $pedido->setEstadoId(2);
        $pedido->setCliente($cliente);
        $pedido->setEmpleado($empleado);
        $pedido->setAndroid_id($android_id);
        
        $em->persist($pedido);
        $em->flush();
        
        
        if ($result == null) {
            $respuesta = array('code'=>$code,
                           'message'=>$message,
                           'data'=>''
                        );
        }else{
            $respuesta = array('code'=>$code,
                           'message'=>$message,
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