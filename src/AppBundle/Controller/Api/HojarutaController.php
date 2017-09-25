<?php


namespace AppBundle\Controller\Api;

use AppBundle\Entity\Marca;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use\Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use \FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;

class HojarutaController extends FOSRestController{
    
    /**
    * @Rest\Get("/api/hojarutas")
    */
    public function getHojarutasAction(){
        $result = $this->getDoctrine()->getRepository('AppBundle:Hojaruta')->findAll();
        if ($result === null) {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }
    
}