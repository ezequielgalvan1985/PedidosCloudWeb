<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pedidodetalle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;

/**
 * Pedidodetalle controller.
 *
 * @Route("pedidodetalle")
 */
class PedidodetalleController extends Controller
{
    /**
     * Lists all pedidodetalle entities.
     *
     * @Route("/", name="pedidodetalle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pedidodetalles = $em->getRepository('AppBundle:Pedidodetalle')->findAll();

        return $this->render('pedidodetalle/index.html.twig', array(
            'pedidodetalles' => $pedidodetalles,
        ));
    }

    /**
     * Creates a new pedidodetalle entity.
     *
     * @Route("/new", name="pedidodetalle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pedidodetalle = new Pedidodetalle();
        $form = $this->createForm('AppBundle\Form\PedidodetalleType', $pedidodetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pedidodetalle);
            $em->flush();

            return $this->redirectToRoute('pedidodetalle_show', array('id' => $pedidodetalle->getId()));
        }

        return $this->render('pedidodetalle/new.html.twig', array(
            'pedidodetalle' => $pedidodetalle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pedidodetalle entity.
     *
     * @Route("/{id}", name="pedidodetalle_show")
     * @Method("GET")
     */
    public function showAction(Pedidodetalle $pedidodetalle)
    {
        $deleteForm = $this->createDeleteForm($pedidodetalle);

        return $this->render('pedidodetalle/show.html.twig', array(
            'pedidodetalle' => $pedidodetalle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pedidodetalle entity.
     *
     * @Route("/{id}/edit", name="pedidodetalle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pedidodetalle $pedidodetalle)
    {
        $deleteForm = $this->createDeleteForm($pedidodetalle);
        $editForm = $this->createForm('AppBundle\Form\PedidodetalleType', $pedidodetalle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pedidodetalle_edit', array('id' => $pedidodetalle->getId()));
        }

        return $this->render('pedidodetalle/edit.html.twig', array(
            'pedidodetalle' => $pedidodetalle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pedidodetalle entity.
     *
     * @Route("/{id}", name="pedidodetalle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pedidodetalle $pedidodetalle)
    {
        $form = $this->createDeleteForm($pedidodetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pedidodetalle);
            $em->flush();
        }

        return $this->redirectToRoute('pedidodetalle_index');
    }

    /**
     * Creates a form to delete a pedidodetalle entity.
     *
     * @param Pedidodetalle $pedidodetalle The pedidodetalle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pedidodetalle $pedidodetalle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedidodetalle_delete', array('id' => $pedidodetalle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
