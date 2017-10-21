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
use AppBundle\Entity\User;
use AppBundle\Entity\Pedidodetalle;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use \FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;

class PedidoController extends FOSRestController{
    
   
    /**
    * @Rest\Post("/api/pedido/add")
    */
    public function postPedidosAction(Request $request){
        //leer json
        
        $content = $request->getContent();
        $code = '200'; $message='OK'; $result = "";
        //parsear detalle
        $json = json_decode($content, true);
        $em = $this->getDoctrine()->getManager();
        //Leer Pedido
        $fecha = $json['pedido']['fecha'];
        $empresa_id = $json['pedido']['empresa_id'];
        $user_id = $json['pedido']['user_id'];
        $android_id = $json['pedido']['android_id'];
        $cliente_id = $json['pedido']['cliente_id'];
      
        $empresa = $this->getDoctrine()->getRepository(Empresa::class)->find($empresa_id);
        if (!$empresa) {
            $code = '500';
            $message = 'no se encontro empresa';
            throw $this->createNotFoundException('No se encuentra Empresa '.$empresa_id);
        }
        $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);
        if(!$user){
            $code = '500';
            $message = 'no se encontro usuario';
            throw $this->createNotFoundException('No se encuentra Usuario '.$user_id);
        }
        
        
        $empleado = $this->getDoctrine()->getRepository(Empleado::class)->findOneByUser($user);
        if(!$empleado){
            $code = '500';
            $message = 'no se encontro empleado';
            throw $this->createNotFoundException('No se encuentra Empleado '.$user->getId());
        }

        $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($cliente_id);
        if(!$cliente){
            $code = '500';
            $message = 'no se encontro cliente';
            throw $this->createNotFoundException('No se encuentra Cliente '.$cliente_id);
           
        }
                
        $pedido = new Pedido();
        $pedido->setEmpresa($empresa);
        $pedido->setFecha(new \DateTime($fecha));
        $pedido->setEstadoId(2);
        $pedido->setCliente($cliente);
        $pedido->setEmpleado($empleado);
        $pedido->setAndroid_id($android_id);
        
        
        /* Leer detalle del pedido 
         * 
         *  
         */
        
        if ($json['pedido']['pedidodetalles']){
            $detalles = $json['pedido']['pedidodetalles'];
            foreach ($detalles as $item){

                $producto_id = $item['producto_id'];
                $android_id = $item['android_id'];
                $cantidad = $item['cantidad'];
                //Validar que producto pertenezca a la Empresa
                $producto = $this->getDoctrine()->getRepository(Producto::class)->find($producto_id);
                if(!$producto){
                    $code = '500';
                    $message = 'no se encontro Producto';
                    throw $this->createNotFoundException('No se encuentra producto '.$producto_id);
                } 
                $pd = new Pedidodetalle();
                $pd->setProducto($producto);
                $pd->setCantidad($cantidad);
                //$pd->setAndroid($android_id);

                $pedido->addPedidodetalle($pd);     
            }
        }         
        $em->persist($pedido);
        $em->flush();
        


        $result = $pedido;
        if ($result == null) {
            $respuesta = array('code'=>Response::HTTP_OK,
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