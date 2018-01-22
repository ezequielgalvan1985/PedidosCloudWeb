<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Pedido;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Cliente;
use AppBundle\Entity\User;
use AppBundle\Entity\Pedidodetalle;
use \AppBundle\Entity\Movimientostock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\GlobalValue;



class PedidoController extends FOSRestController{
    
    
    
    
    
    /**
     * @Rest\Post("/api/pedidos")
    */
    public function postPedidosListAction(Request $request){
        try{
            
            $content = $request->getContent();
            $code = Response::HTTP_OK; 
            $message='OK'; 
            $result = "";
            $pedido = new Pedido();
            $json = json_decode($content, true);
            $fecha_desde='';
            $fecha_hasta ='';
            $cliente='';
            $user='';
            $empresa='';
            //Preparar parametros
            /*
             * Fecha desde
             * Fecha Hasta 
             * Empresa Id
             * User Id
             * Cliente Id
             * Estado Id
             *  
             * */
            
            
            
            if (array_key_exists ('empresa_id',$json)){
                $empresa_id  = $json['empresa_id'];
                $empresa = $this->getDoctrine()->getRepository(Empresa::class)->find($empresa_id);
                if (!$empresa) {
                    $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro empresa', 'data'=>$result);
                    return $respuesta;
                }   
            }else{
                $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'La Empresa es Obligatorio', 'data'=>$result);
                return $respuesta;
            }
            $queryBuilder = $this->getDoctrine()->getRepository(Pedido::class)->createQueryBuilder('p');
            $queryBuilder->where('p.empresa = :empresa')->setParameter('empresa', $empresa);
            
            
            if (array_key_exists ('user_id', $json)){
                $user_id     = $json['user_id'];
                $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);
                if (!$user) {
                    $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro usuario', 'data'=>$result);
                    return $respuesta;
                }
                $queryBuilder->andWhere('p.user = :user')->setParameter('user',  $user);   
            }
            
            if (array_key_exists ('cliente_id',$json)){
                $cliente_id  = $json['cliente_id'];
                $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($cliente_id);
                if (!$cliente) {
                    $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro cliente', 'data'=>$result);
                    return $respuesta;
                }
                $queryBuilder->andWhere('p.cliente = :cliente')->setParameter('cliente',  $cliente);   
            }
            
            if (array_key_exists ('fecha_desde', $json)){
                $fecha_desde = $json['fecha_desde'];
                $fecha_desde = (new \DateTime($fecha_desde));
                $queryBuilder->andWhere('p.fecha >= :fechadesde')->setParameter('fechadesde',  $fecha_desde);   
            }
            
            if (array_key_exists ('fecha_hasta',$json)){
                $fecha_hasta = $json['fecha_hasta'];
                $fecha_hasta = (new \DateTime($fecha_hasta));
                $queryBuilder->andWhere('p.fecha <= :fechahasta')->setParameter('fechahasta',  $fecha_hasta);   
            }
            
            if (array_key_exists ('estado_id',$json)){
                $estado_id  = $json['estado_id'];
                $queryBuilder->andWhere('p.estadoId = :estadoid')->setParameter('estadoid',  $estado_id);   
            }
            
            
            $registros = $queryBuilder->getQuery();
            $respuesta = array('code'=>$code,
                               'message'=>$message,
                               'pedidos'=>$registros->execute(),
                               'response' => 'success',
                            );
            
            
            

            return $respuesta;
            
        }catch(Exception $e){
            return $respuesta;
        }
    }
    
    
    
    
    
    
    
    /**
    * @Rest\Post("/api/pedido/add")
    */
    public function postPedidosAddAction(Request $request){
        //leer json
        
        $content = $request->getContent();
        $pedido = new Pedido();
        $code = Response::HTTP_OK; 
        $message='OK'; 
        $result = "";
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
            
            $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro empresa', 'data'=>$result);
            return $respuesta;
        }
        
        $user = $this->getDoctrine()->getRepository(User::class)->find($user_id);
        if(!$user){
            $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro usuario', 'data'=>$result);
            return $respuesta;
        }
       
        $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($cliente_id);
        if(!$cliente){
            $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro cliente', 'data'=>$result);
            return $respuesta;
        }
        
        
        if ($code==Response::HTTP_OK){        
            $pedido->setEmpresa($empresa);
            $pedido->setFecha(new \DateTime($fecha));
            $pedido->setEstadoId(GlobalValue::ENVIADO);
            $pedido->setCliente($cliente);
            //$pedido->setEmpleado($empleado);
            $pedido->setAndroid_id($android_id);
        
            if ($json['pedido']['pedidodetalles']){
                $detalles = $json['pedido']['pedidodetalles'];
                foreach ($detalles as $item){
                    $producto_id = $item['producto_id'];
                    $android_id = $item['android_id'];
                    $cantidad = $item['cantidad'];

                    //Validar que producto pertenezca a la Empresa
                    $producto = new Producto();
                    $producto = $this->getDoctrine()->getRepository(Producto::class)->find($producto_id);
                    if(!$producto){
                        $respuesta = array('code'=>Response::HTTP_PRECONDITION_REQUIRED,  'message'=>'No se encontro Producto', 'data'=>$result);
                        return $respuesta;
                         
                    } 
                    $pd = new Pedidodetalle();
                    $pd->setProducto($producto);
                    $pd->setCantidad($cantidad);
                    $pedido->addPedidodetalle($pd);     
                    
                    //Generar movimiento de Stock
                    $mv = new Movimientostock();
                    $mv->setCantidad($cantidad);
                    $mv->setFecha(new \DateTime($fecha));
                    $mv->setEmpresa($empresa);
                    $mv->setNrocomprobante("Nro Android: " . $android_id );
                    $mv->setProducto($producto);
                    $mv->setTipomovimiento(GlobalValue::EGRESO);
                    
                    //Actualizar cantidad de producto en Maestro de Productos prueba
                    $stock = $producto->getStock();
                    $stockactual = $stock - $cantidad;
                    $producto->setStock($stockactual);
                    
                    
                }
            }         
            $em->persist($producto);
            $em->persist($pedido);
            $em->persist($mv);
            $em->flush();
        }//Si paso validacion

        $respuesta = array('code'=>$code,
                           'message'=>$message,
                           'data'=>$pedido
                        );
        return $respuesta;
    }
    
    
    
    
    /**
    * @Rest\Post("/api/pedidodetalle/edit")
    */
    public function postPedidodetalleeditAction(Request $request){
        //leer json
        try{
           
            $pedido = new Pedido();
            $code = Response::HTTP_OK; 
            $message='OK'; 
            $result = "";
            //parsear detalle
            $content = $request->getContent();
            $json = json_decode($content, true);
            $em = $this->getDoctrine()->getManager();
            //Leer Pedido

            $id = $json['id'];
            $cantidad = $json['cantidad'];


            $pd = new Pedidodetalle();
            $pd = $this->getDoctrine()->getRepository(Pedidodetalle::class)->find($id);
            if (!$pd) {
                throw $this->createNotFoundException(
                    'No Pedidodetalle found for id '.$id
                );
            }
            $pd->setCantidad($cantidad);
            
            //Generar movimiento de Stock
            
            
            
            $em->persist($pd);
            
            
            $em->flush();

            $response = array('code'=>$code,
                               'message'=>$message,
                               'data'=>$pd
                            );
            return $response;
            }catch(Exception $e){
                $response = array('code'=>Response::HTTP_CONFLICT,
                               'message'=>$e->getMessage(),
                               'data'=>null
                            );
                return $response;
                
            }
    }
    
    /**
    * @Rest\Get("/api/check")
    */
    public function getCheckAction(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        return $user;
    }
}