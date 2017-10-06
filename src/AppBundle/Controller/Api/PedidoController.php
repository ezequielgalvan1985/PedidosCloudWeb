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
    * @Rest\Post("/api/pedido/add/")
    */
    public function postPedidosAction(Request $request){
        //leer json
        $content = $request->getContent();
        $code = '200'; $message='OK';
        //parsear detalle
        $json = json_decode($content, true);
        $em = $this->getDoctrine()->getManager();
        //Leer Pedido
        $empresa_id = $json['pedido']['empresa_id'];
        $fecha = $json['pedido']['fecha'];
        $empleado_id = $json['pedido']['empleado_id'];
        
        $empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findById($empresa_id);
        if(!$empresa){
            $code = '500';
            $message = 'no se encontro empresa';
        }
        $empleado = $this->getDoctrine()->getRepository('AppBundle:Empleado')->findById($empleado_id);
        if(!$empleado){
            $code = '500';
            $message = 'no se encontro empleado';
        }
        $android_id = $json['pedido']['android_id'];
        
        $pedido = new Pedido();
        $pedido->setEmpresa($empresa);
        //validar fecha
        $pedido->setFecha($fecha);
        
        //validar empleado
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