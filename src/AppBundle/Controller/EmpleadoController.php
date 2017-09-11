<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Empleado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\User\User;

/**
 * Empleado controller.
 *
 * @Route("empleado")
 */
class EmpleadoController extends Controller
{
    /**
     * Lists all empleado entities.
     *
     * @Route("/", name="empleado_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Empleado::class);
        //Obtener empresa
        $currentuser = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $currentuser->getEmpresa();
        $registros = $repository->findByEmpresa($empresa);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),10);
        return $this->render('empleado/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new empleado entity.
     *
     * @Route("/new", name="empleado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $empleado = new Empleado();
        $form = $this->createForm('AppBundle\Form\EmpleadoType', $empleado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Obtener Empresa
            $currentuser = $this->get('security.token_storage')->getToken()->getUser();
            $empresa = $currentuser->getEmpresa();
             //Crea empleado
            $username = $empleado->getNombre() . $empleado->getApellido() . $empleado->getId() ;
            $empleado->setUsername($username);
            $empleado->setEmpresa($empresa);
            $em->persist($empleado);
            $em->flush();
            
            
            //Crear usuario
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->createUser();
            
            $user->setUsername($username);
            $user->setEmail($empleado->getEmail());
            $user->setEmailCanonical($empleado->getEmail());
            $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
            // this method will encrypt the password with the default settings :)
            $password = 12345678;
            $user->setRoles(array($empleado->getTipo()));
            $user->setPlainPassword($password);
            $user->setEmpresa($empresa);
            $userManager->updateUser($user);
            
            
            return $this->redirectToRoute('empleado_show', array('id' => $empleado->getId()));
        }

        return $this->render('empleado/new.html.twig', array(
            'empleado' => $empleado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a empleado entity.
     *
     * @Route("/{id}", name="empleado_show")
     * @Method("GET")
     */
    public function showAction(Empleado $empleado)
    {
        $deleteForm = $this->createDeleteForm($empleado);

        return $this->render('empleado/show.html.twig', array(
            'empleado' => $empleado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing empleado entity.
     *
     * @Route("/{id}/edit", name="empleado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Empleado $empleado)
    {
        $deleteForm = $this->createDeleteForm($empleado);
        $editForm = $this->createForm('AppBundle\Form\EmpleadoType', $empleado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('empleado_edit', array('id' => $empleado->getId()));
        }

        return $this->render('empleado/edit.html.twig', array(
            'empleado' => $empleado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a empleado entity.
     *
     * @Route("/{id}", name="empleado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Empleado $empleado)
    {
        $form = $this->createDeleteForm($empleado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($empleado);
            $em->flush();
        }

        return $this->redirectToRoute('empleado_index');
    }

    /**
     * Creates a form to delete a empleado entity.
     *
     * @param Empleado $empleado The empleado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Empleado $empleado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('empleado_delete', array('id' => $empleado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
