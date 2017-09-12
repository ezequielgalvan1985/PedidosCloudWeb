<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hojarutadetalle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
/**
 * Hojarutadetalle controller.
 *
 * @Route("hojarutadetalle")
 */
class HojarutadetalleController extends Controller
{
    /**
     * Lists all hojarutadetalle entities.
     *
     * @Route("/", name="hojarutadetalle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hojarutadetalles = $em->getRepository('AppBundle:Hojarutadetalle')->findAll();

        return $this->render('hojarutadetalle/index.html.twig', array(
            'hojarutadetalles' => $hojarutadetalles,
        ));
    }

    /**
     * Creates a new hojarutadetalle entity.
     *
     * @Route("/new/{hojaruta_id}", name="hojarutadetalle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hojarutadetalle = new Hojarutadetalle();
        $form = $this->createForm('AppBundle\Form\HojarutadetalleType', $hojarutadetalle);
        $form->handleRequest($request);
        //Leer datos de la hoja de ruta
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hojarutadetalle);
            $em->flush();

            return $this->redirectToRoute('hojarutadetalle_show', array('id' => $hojarutadetalle->getId()));
        }

        return $this->render('hojarutadetalle/new.html.twig', array(
            'hojarutadetalles' => $hojarutadetalles,
            'hojaruta' => $hojaruta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hojarutadetalle entity.
     *
     * @Route("/{id}", name="hojarutadetalle_show")
     * @Method("GET")
     */
    public function showAction(Hojarutadetalle $hojarutadetalle)
    {
        $deleteForm = $this->createDeleteForm($hojarutadetalle);

        return $this->render('hojarutadetalle/show.html.twig', array(
            'hojarutadetalle' => $hojarutadetalle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hojarutadetalle entity.
     *
     * @Route("/{id}/edit", name="hojarutadetalle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hojarutadetalle $hojarutadetalle)
    {
        $deleteForm = $this->createDeleteForm($hojarutadetalle);
        $editForm = $this->createForm('AppBundle\Form\HojarutadetalleType', $hojarutadetalle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hojarutadetalle_edit', array('id' => $hojarutadetalle->getId()));
        }

        return $this->render('hojarutadetalle/edit.html.twig', array(
            'hojarutadetalle' => $hojarutadetalle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hojarutadetalle entity.
     *
     * @Route("/{id}", name="hojarutadetalle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hojarutadetalle $hojarutadetalle)
    {
        $form = $this->createDeleteForm($hojarutadetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hojarutadetalle);
            $em->flush();
        }

        return $this->redirectToRoute('hojarutadetalle_index');
    }

    /**
     * Creates a form to delete a hojarutadetalle entity.
     *
     * @param Hojarutadetalle $hojarutadetalle The hojarutadetalle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hojarutadetalle $hojarutadetalle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hojarutadetalle_delete', array('id' => $hojarutadetalle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
