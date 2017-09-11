<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hojaruta;
use Symfony\Component\Security\Core\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hojarutum controller.
 *
 * @Route("hojaruta")
 */
class HojarutaController extends Controller
{
    /**
     * Lists all hojaruta entities.
     *
     * @Route("/", name="hojaruta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hojarutas = $em->getRepository('AppBundle:Hojaruta')->findAll();

        return $this->render('hojaruta/index.html.twig', array(
            'hojarutas' => $hojarutas,
        ));
    }

    /**
     * Creates a new hojaruta entity.
     *
     * @Route("/new", name="hojaruta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hojaruta = new Hojaruta();
        $form = $this->createForm('AppBundle\Form\HojarutaType', $hojaruta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Obtener Empresa
            $currentuser = $this->get('security.token_storage')->getToken()->getUser();
            
            $empresa = $currentuser->getEmpresa();
           
            $hojaruta->setEmpresa($empresa);
            
            $em->persist($hojaruta);
            $em->flush();

            return $this->redirectToRoute('hojaruta_show', array('id' => $hojaruta->getId()));
        }

        return $this->render('hojaruta/new.html.twig', array(
            'hojaruta' => $hojaruta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hojaruta entity.
     *
     * @Route("/{id}", name="hojaruta_show")
     * @Method("GET")
     */
    public function showAction(Hojaruta $hojaruta)
    {
        $deleteForm = $this->createDeleteForm($hojaruta);

        return $this->render('hojaruta/show.html.twig', array(
            'hojaruta' => $hojaruta,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hojaruta entity.
     *
     * @Route("/{id}/edit", name="hojaruta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hojaruta $hojaruta)
    {
        $deleteForm = $this->createDeleteForm($hojaruta);
        $editForm = $this->createForm('AppBundle\Form\HojarutaType', $hojaruta);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hojaruta_edit', array('id' => $hojaruta->getId()));
        }

        return $this->render('hojaruta/edit.html.twig', array(
            'hojaruta' => $hojaruta,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hojaruta entity.
     *
     * @Route("/{id}", name="hojaruta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hojaruta $hojaruta)
    {
        $form = $this->createDeleteForm($hojaruta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hojaruta);
            $em->flush();
        }

        return $this->redirectToRoute('hojaruta_index');
    }

    /**
     * Creates a form to delete a hojaruta entity.
     *
     * @param Hojaruta $hojaruta The hojaruta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hojaruta $hojaruta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hojaruta_delete', array('id' => $hojaruta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
