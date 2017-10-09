<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Condicioniva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Condicioniva controller.
 *
 * @Route("condicioniva")
 */
class CondicionivaController extends Controller
{
    /**
     * Lists all condicioniva entities.
     *
     * @Route("/", name="condicioniva_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $condicionivas = $em->getRepository('AppBundle:Condicioniva')->findAll();

        return $this->render('condicioniva/index.html.twig', array(
            'condicionivas' => $condicionivas,
        ));
    }

    /**
     * Creates a new condicioniva entity.
     *
     * @Route("/new", name="condicioniva_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $condicioniva = new Condicioniva();
        $form = $this->createForm('AppBundle\Form\CondicionivaType', $condicioniva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $condicioniva->setEmpresa($this->get('security.token_storage')->getToken()->getUser()->getEmpresa());    
            $em->persist($condicioniva);
            $em->flush();

            return $this->redirectToRoute('condicioniva_show', array('id' => $condicioniva->getId()));
        }

        return $this->render('condicioniva/new.html.twig', array(
            'condicioniva' => $condicioniva,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a condicioniva entity.
     *
     * @Route("/{id}", name="condicioniva_show")
     * @Method("GET")
     */
    public function showAction(Condicioniva $condicioniva)
    {
        $deleteForm = $this->createDeleteForm($condicioniva);

        return $this->render('condicioniva/show.html.twig', array(
            'condicioniva' => $condicioniva,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing condicioniva entity.
     *
     * @Route("/{id}/edit", name="condicioniva_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Condicioniva $condicioniva)
    {
        $deleteForm = $this->createDeleteForm($condicioniva);
        $editForm = $this->createForm('AppBundle\Form\CondicionivaType', $condicioniva);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('condicioniva_edit', array('id' => $condicioniva->getId()));
        }

        return $this->render('condicioniva/edit.html.twig', array(
            'condicioniva' => $condicioniva,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a condicioniva entity.
     *
     * @Route("/{id}", name="condicioniva_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Condicioniva $condicioniva)
    {
        $form = $this->createDeleteForm($condicioniva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($condicioniva);
            $em->flush();
        }

        return $this->redirectToRoute('condicioniva_index');
    }

    /**
     * Creates a form to delete a condicioniva entity.
     *
     * @param Condicioniva $condicioniva The condicioniva entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Condicioniva $condicioniva)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('condicioniva_delete', array('id' => $condicioniva->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
