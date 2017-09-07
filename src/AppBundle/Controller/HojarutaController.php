<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hojaruta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Hojarutum controller.
 *
 * @Route("hojaruta")
 */
class HojarutaController extends Controller
{
    /**
     * Lists all hojarutum entities.
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
     * Creates a new hojarutum entity.
     *
     * @Route("/new", name="hojaruta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hojarutum = new Hojarutum();
        $form = $this->createForm('AppBundle\Form\HojarutaType', $hojarutum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hojarutum);
            $em->flush();

            return $this->redirectToRoute('hojaruta_show', array('id' => $hojarutum->getId()));
        }

        return $this->render('hojaruta/new.html.twig', array(
            'hojarutum' => $hojarutum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hojarutum entity.
     *
     * @Route("/{id}", name="hojaruta_show")
     * @Method("GET")
     */
    public function showAction(Hojaruta $hojarutum)
    {
        $deleteForm = $this->createDeleteForm($hojarutum);

        return $this->render('hojaruta/show.html.twig', array(
            'hojarutum' => $hojarutum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hojarutum entity.
     *
     * @Route("/{id}/edit", name="hojaruta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hojaruta $hojarutum)
    {
        $deleteForm = $this->createDeleteForm($hojarutum);
        $editForm = $this->createForm('AppBundle\Form\HojarutaType', $hojarutum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hojaruta_edit', array('id' => $hojarutum->getId()));
        }

        return $this->render('hojaruta/edit.html.twig', array(
            'hojarutum' => $hojarutum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hojarutum entity.
     *
     * @Route("/{id}", name="hojaruta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hojaruta $hojarutum)
    {
        $form = $this->createDeleteForm($hojarutum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hojarutum);
            $em->flush();
        }

        return $this->redirectToRoute('hojaruta_index');
    }

    /**
     * Creates a form to delete a hojarutum entity.
     *
     * @param Hojaruta $hojarutum The hojarutum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hojaruta $hojarutum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hojaruta_delete', array('id' => $hojarutum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
