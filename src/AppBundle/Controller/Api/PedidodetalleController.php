<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Pedidodetalle;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\GlobalValue;



class PedidodetalleController extends FOSRestController{
    
   
    /**
     * @Route("/ajax/pedido/detalle/edit", name="ajax_pedidodetalleedit")
     * @Method({"GET","POST"})
     */
    public function pedidodetalleeditAction(Request $request)
    {
        try{
            
            $content = $request->getContent();
            $code = Response::HTTP_OK; 
            $message='OK'; 
            $result = "";
            $json     = json_decode($content, true);
            $id       = $json['id'];
            $cantidad = $json['cantidad'];
            
            debug('debug1');
            //calcular valores de monto
            $em = $this->getDoctrine()->getManager();
            $item = $this->getDoctrine()
                ->getRepository(Pedidodetalle::class)
                ->findBy(array('id'=>$id));
            
            $item->setCantidad($cantidad);
            $monto = $cantidad * $item->getPrecio();
            $item->setMonto($monto);
            $em->persist($item);
            
            
            $respuesta = array('code'=>$code,
                               'message'=>$message,
                               'item'=>$item,
                               'response' => 'success',
                            );

            return $respuesta;
            
        }catch(Exception $e){
            $respuesta = array('code'=>Response::HTTP_BAD_REQUEST,
                               'message'=>$e->getMessage(),
                               'item'=>null,
                               'response' => 'error',
                            );
            return $respuesta;
        }
    }
    
    
    
}