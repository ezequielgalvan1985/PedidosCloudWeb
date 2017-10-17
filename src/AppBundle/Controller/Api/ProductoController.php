<?php 
namespace AppBundle\Controller\Api;

use AppBundle\Entity\Categoria;

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

class ProductoController extends FOSRestController
{
   /**
    * @Rest\Post("/api/productos")
    */
    public function getProductosAction(Request $request){
        $empresa_id = $request->get('empresa_id');
        $empresa = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findById($empresa_id);
        $result = $this->getDoctrine()->getRepository('AppBundle:Producto')->findByEmpresa($empresa);
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

?>