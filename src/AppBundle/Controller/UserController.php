<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;


use AppBundle\Entity\User;
/**
 * 
 *
 * @Route("users")
 */
class UserController extends Controller
{
    
/**
 * 
 *
 * @Route("/change", name="user_change")
 * @Method({"GET", "POST"})
 */
    public function changePasswordAction(Request $request)
    {
     $user = $this->getUser();
      //dispatch the appropriate events

    /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    $dispatcher = $this->get('event_dispatcher');

    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE,            $event);

    if (null !== $event->getResponse()) {
        return $event->getResponse();
    }


 /**
  * this is where you start the initialization of the form to you use
  */

    /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface           */
    $formFactory = $this->get('fos_user.change_password.form.factory');

    $form = $formFactory->createForm();
      //pass in the user data
    $form->setData($user);

    $form->handleRequest($request);

    if ($form->isValid()) {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            //here you set the url to go to after changing the password
              //for example i am redirecting back to the page  that triggered the change password process
            $url = $this->generateUrl('showProfileAccount');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    return $this->render('FOSUserBundle:ChangePassword:changePassword.html.twig', array(
       //note remove this comment. pass the form to template
        'form' => $form->createView()
    ));
    }
}