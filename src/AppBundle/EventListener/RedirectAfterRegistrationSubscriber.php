<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\EventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use FOS\UserBundle\FOSUserEvents;

class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface
{
    private $router;
    
    public function __construct( RouterInterface $router) {
        $this->router = $router;
    }
    
    public function onRegistrationSuccess(FormEvent $form){
        $url = $this->router->generate('homepage');
        $respose = new RedirectResponse($url);
        $event->setResponse($response);
    }
    
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        ];
    }

}