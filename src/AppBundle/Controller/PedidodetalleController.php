<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pedidodetalle;
use AppBundle\Entity\Pedido;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\GlobalValue;


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
     * @Route("/new/{pedido_id}", name="pedidodetalle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $pedido_id)
    {
        $pedidodetalle = new Pedidodetalle();
        //Obtener Hojaruta y Hojarutadetalles
        $repository = $this->getDoctrine()->getRepository(Pedido::class);
        $pedido = $repository->findOneById($pedido_id);
        $pedidodetalles = $pedido->getPedidodetalles();
        //Fin consulta de datos
        $formchangestatus = $this->createChangeStatusForm($pedido);
        
        
        $form = $this->createForm('AppBundle\Form\PedidodetalleType', $pedidodetalle);
        $form->add('producto', EntityType::class, array(
                        'class' => 'AppBundle:Producto',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'textocombo'
                    ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pedidodetalle->setPedido($pedido);
            $em->persist($pedidodetalle);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('pedidodetalle_new', array('pedido_id' => $pedido->getId()));
        }

        return $this->render('pedidodetalle/new.html.twig', array(
            'pedidodetalles' => $pedidodetalles,
            'pedido'=>$pedido,
            'estados'=> GlobalValue::ESTADOS,
            'preparado' => GlobalValue::PREPARADO_DISPLAY,
            'preparadoid' => GlobalValue::PREPARADO,
            'form' => $form->createView(),
            'formchangestatus'=> $formchangestatus->createView()
        ));
    }
    
    
    private function createChangeStatusForm(Pedido $pedido)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedido_change', array('id' => $pedido->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
    
    /**
     * Deletes a pedido entity.
     *
     * @Route("/{id}", name="pedido_change")
     * @Method("POST")
     */
    public function changeStatusAction(Request $request, Pedido $pedido)
    {
        $form = $this->createChangeStatusForm($pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pedido->setEstadoId(GlobalValue::PREPARADO);
            $em->persist($pedido);
            $em->flush();
        }

        return $this->redirectToRoute('pedido_index');
    }
    
    
    
    
    
    /**
     * Creates a new pedidodetalle entity.
     *
     * @Route("/cambioestado", name="pedidodetalle_cambioestado")
     * @Method({"POST"})
     */
    public function cambiarestadoAction(Request $request)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Pedido::class);
            $pedido_id = $this->get('request')->request->get('pedido_id');
            
            $pedido = $repository->findOneById($pedido_id);
            $pedido->setEstado(GlobalValue::PREPARADO);
            
            $em->persist($pedido);
            $em->flush();
            $this->addFlash(  'success','Pedido Preparado!');
            return $this->redirectToRoute('pedidodetalle_new', array('pedido_id' => $pedido->getId()));
        }

        return $this->render('pedidodetalle/new.html.twig', array('pedido'=>$pedido));
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
            $this->addFlash(  'success','Guardado Correctamente!');
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
     * @Route("/delete/{id}", name="pedidodetalle_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Pedidodetalle $pedidodetalle)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($pedidodetalle);
        $em->flush();

        return $this->redirectToRoute('pedidodetalle_new',array('pedido_id' => $pedidodetalle->getPedido()->getId()));
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
