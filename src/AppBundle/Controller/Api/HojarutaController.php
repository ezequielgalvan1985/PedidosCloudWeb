<?php
namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use \FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class HojarutaController extends FOSRestController{
    
    /**
    * @Rest\Post("/api/hojarutas")
    */
    public function getHojarutasAction(Request $request){
        $empresa_id = $request->get('empresa_id');
        $empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findById($empresa_id);
        $result = $this->getDoctrine()->getRepository('AppBundle:Hojaruta')->findByEmpresa($empresa);
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
    
}