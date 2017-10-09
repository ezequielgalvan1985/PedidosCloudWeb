<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Impuesto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Impuesto controller.
 *
 * @Route("impuesto")
 */
class ImpuestoController extends Controller
{
    /**
     * Lists all impuesto entities.
     *
     * @Route("/", name="impuesto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $impuestos = $em->getRepository('AppBundle:Impuesto')->findAll();

        return $this->render('impuesto/index.html.twig', array(
            'impuestos' => $impuestos,
        ));
    }

    /**
     * Creates a new impuesto entity.
     *
     * @Route("/new", name="impuesto_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $impuesto = new Impuesto();
        $form = $this->createForm('AppBundle\Form\ImpuestoType', $impuesto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $impuesto->setEmpresa($this->get('security.token_storage')->getToken()->getUser()->getEmpresa());    
            $em->persist($impuesto);
            $em->flush();

            return $this->redirectToRoute('impuesto_show', array('id' => $impuesto->getId()));
        }

        return $this->render('impuesto/new.html.twig', array(
            'impuesto' => $impuesto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a impuesto entity.
     *
     * @Route("/{id}", name="impuesto_show")
     * @Method("GET")
     */
    public function showAction(Impuesto $impuesto)
    {
        $deleteForm = $this->createDeleteForm($impuesto);

        return $this->render('impuesto/show.html.twig', array(
            'impuesto' => $impuesto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing impuesto entity.
     *
     * @Route("/{id}/edit", name="impuesto_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Impuesto $impuesto)
    {
        $deleteForm = $this->createDeleteForm($impuesto);
        $editForm = $this->createForm('AppBundle\Form\ImpuestoType', $impuesto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('impuesto_edit', array('id' => $impuesto->getId()));
        }

        return $this->render('impuesto/edit.html.twig', array(
            'impuesto' => $impuesto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a impuesto entity.
     *
     * @Route("/{id}", name="impuesto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Impuesto $impuesto)
    {
        $form = $this->createDeleteForm($impuesto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($impuesto);
            $em->flush();
        }

        return $this->redirectToRoute('impuesto_index');
    }

    /**
     * Creates a form to delete a impuesto entity.
     *
     * @param Impuesto $impuesto The impuesto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Impuesto $impuesto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('impuesto_delete', array('id' => $impuesto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
