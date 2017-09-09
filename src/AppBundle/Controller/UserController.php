<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("producto")
 */
class UserController extends Controller
{
    /**
    * This method registers an user in the database manually.
    *
    * @return boolean User registered / not registered
    **/
   private function register($email,$username,$password){    
      $userManager = $this->get('fos_user.user_manager');

      // Or you can use the doctrine entity manager if you want instead the fosuser manager
      // to find 
      //$em = $this->getDoctrine()->getManager();
      //$usersRepository = $em->getRepository("mybundleuserBundle:User");
      // or use directly the namespace and the name of the class 
      // $usersRepository = $em->getRepository("mybundle\userBundle\Entity\User");
      //$email_exist = $usersRepository->findOneBy(array('email' => $email));
      
      $email_exist = $userManager->findUserByEmail($email);

      // Check if the user exists to prevent Integrity constraint violation error in the insertion
      if($email_exist){
          return false;
      }

      $user = $userManager->createUser();
      $user->setUsername($username);
      $user->setEmail($email);
      $user->setEmailCanonical($email);
      $user->setLocked(0); // don't lock the user
      $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
      // this method will encrypt the password with the default settings :)
      $user->setPlainPassword($password);
      $userManager->updateUser($user);

      return true;
   }
    
}
