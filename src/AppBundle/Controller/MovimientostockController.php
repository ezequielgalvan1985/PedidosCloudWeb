<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movimientostock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Movimientostock controller.
 *
 * @Route("movimientostock")
 */
class MovimientostockController extends Controller
{
    /**
     * Lists all movimientostock entities.
     *
     * @Route("/", name="movimientostock_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $movimientostocks = $em->getRepository('AppBundle:Movimientostock')->findAll();

        return $this->render('movimientostock/index.html.twig', array(
            'movimientostocks' => $movimientostocks,
        ));
    }

    /**
     * Creates a new movimientostock entity.
     *
     * @Route("/new", name="movimientostock_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $movimientostock = new Movimientostock();
        $form = $this->createForm('AppBundle\Form\MovimientostockType', $movimientostock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movimientostock);
            $em->flush();

            return $this->redirectToRoute('movimientostock_show', array('id' => $movimientostock->getId()));
        }

        return $this->render('movimientostock/new.html.twig', array(
            'movimientostock' => $movimientostock,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a movimientostock entity.
     *
     * @Route("/{id}", name="movimientostock_show")
     * @Method("GET")
     */
    public function showAction(Movimientostock $movimientostock)
    {
        $deleteForm = $this->createDeleteForm($movimientostock);

        return $this->render('movimientostock/show.html.twig', array(
            'movimientostock' => $movimientostock,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing movimientostock entity.
     *
     * @Route("/{id}/edit", name="movimientostock_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Movimientostock $movimientostock)
    {
        $deleteForm = $this->createDeleteForm($movimientostock);
        $editForm = $this->createForm('AppBundle\Form\MovimientostockType', $movimientostock);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movimientostock_edit', array('id' => $movimientostock->getId()));
        }

        return $this->render('movimientostock/edit.html.twig', array(
            'movimientostock' => $movimientostock,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a movimientostock entity.
     *
     * @Route("/{id}", name="movimientostock_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Movimientostock $movimientostock)
    {
        $form = $this->createDeleteForm($movimientostock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movimientostock);
            $em->flush();
        }

        return $this->redirectToRoute('movimientostock_index');
    }

    /**
     * Creates a form to delete a movimientostock entity.
     *
     * @param Movimientostock $movimientostock The movimientostock entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Movimientostock $movimientostock)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movimientostock_delete', array('id' => $movimientostock->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
