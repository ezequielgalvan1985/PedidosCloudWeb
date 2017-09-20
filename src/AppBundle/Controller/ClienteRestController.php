<?php

namespace AppBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Marca;

class ClienteRestController extends FOSRestController
{
    public function getUsersAction()
    {
        $repository = $this->getDoctrine()->getRepository(Marca::class);
        $data = $repository->findAll();; // get data, in this case list of users.
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:Cliente:getUsers.html.twig")
            ->setTemplateVar('users')
        ;

        return $this->handleView($view);
    }

    public function redirectAction()
    {
        $view = $this->redirectView($this->generateUrl('some_route'), 301);
        // or
        $view = $this->routeRedirectView('some_route', array(), 301);

        return $this->handleView($view);
    }
}


?>
