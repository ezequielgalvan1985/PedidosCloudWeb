<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller\Api;
use AppBundle\Entity\User;

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

class UserController extends FOSRestController
{
    
 /**
  * @Rest\Post("/api/user/login")
  */
  public function loginJson(Request $request)
  {
    $content = $request->getContent();
    $code = '200'; $message='OK'; $result = ""; $bool=false;
    //$json = json_decode($content, true);
    $username = $request->get('username');
    $password = $request->get('password');
    $user_manager = $this->get('fos_user.user_manager');
    $factory = $this->get('security.encoder_factory');
    $user = $user_manager->findUserByUsername($username);
    if ($user){
        $encoder = $factory->getEncoder($user);  
        $bool = $encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt());
    }
    
    if ($bool==true){
        $respuesta = array('code'=>Response::HTTP_OK,
                           'message'=>$message,
                           'data'=>$user
                        );
    }else{
        $respuesta = array('code'=>Response::HTTP_UNAUTHORIZED,
                           'message'=>'Usuario y/o Contraseña Invalido',
                           'data'=>''
                        );  
    }
    return $respuesta;
}
   
}
