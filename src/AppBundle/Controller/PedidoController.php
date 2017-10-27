<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pedido;
use AppBundle\Entity\GlobalValue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityRepository;

/**
 * Pedido controller.
 *
 * @Route("pedido")
 */
class PedidoController extends Controller
{
    /**
     * Lists all pedido entities.
     *
     * @Route("/", name="pedido_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
       
        //Obtener empresa
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        
       
        //Crear formulario de filtro
        $pedido = new Pedido();
        $form_filter = $this->createForm('AppBundle\Form\PedidoFilterType', $pedido);
        $form_filter->add('empleado', EntityType::class, array(
                        'class' => 'AppBundle:Empleado', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'TextoCombo'))
                    ->add('buscar', SubmitType::class, array('label' => 'Buscar', 'attr'=>array('class'=>'btn btn-flat btn-default')));
         
        $form_filter->handleRequest($request);
        
        $queryBuilder = $this->getDoctrine()->getRepository(Pedido::class)->createQueryBuilder('bp');
        $queryBuilder->where('bp.empresa = :empresa')->setParameter('empresa', $empresa);
        
        //Filtros
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($pedido->getFechadesde()){
                $queryBuilder->andWhere('bp.fecha >= :fechadesde')
                             ->setParameter('fechadesde',  $pedido->getFechadesde());   
            }
            if ($pedido->getFechahasta()){
                $queryBuilder->andWhere('bp.fecha <= :fechahasta')
                             ->setParameter('fechahasta',  $pedido->getFechahasta());   
            }
            if ($pedido->getEstadoId()){
                $queryBuilder->andWhere('bp.estadoId = :estadoid')
                             ->setParameter('estadoid',  $pedido->getEstadoId());   
            }
            if ($pedido->getEmpleado()){
                $queryBuilder->andWhere('bp.empleado = :empleado')
                             ->setParameter('empleado',  $pedido->getEmpleado());   
            }
        }
        
        $registros = $queryBuilder;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),8);
        
        
        return $this->render('pedido/index.html.twig', array(
            'pagination' => $pagination, 
            'form_filter'=>$form_filter->createView(), 
            'estados'=> GlobalValue::ESTADOS
            
        ));
    }
    
    /**
     * Lists all pedido entities.
     *
     * @Route("/hoy", name="pedido_hoy")
     * @Method({"GET","POST"})
     */
    public function hoyAction(Request $request)
    {
         //Obtener empresa
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        // Filtrar por Empresa y por fecha de hoy
        //setlocale(LC_TIME,"es_AR");
        $hoy = date("Y-m-d");
        
        $queryBuilder = $this->getDoctrine()->getRepository(Pedido::class)->createQueryBuilder('bp');
        $queryBuilder->where('bp.empresa = :empresa')
                     ->setParameter('empresa', $empresa);
        $queryBuilder->andWhere('bp.fecha = :hoy')
                     ->setParameter('hoy', $hoy ); 
        
        
        //Crear formulario de filtro
        $pedido = new Pedido();
        $form_filter = $this->createForm('AppBundle\Form\PedidoHoyFilterType', $pedido);
        $form_filter->add('empleado', EntityType::class, array(
                        'class' => 'AppBundle:Empleado', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'TextoCombo'))
                    ->add('buscar', SubmitType::class, array('label' => 'Buscar', 'attr'=>array('class'=>'btn btn-flat btn-default')));
         
                        
        $form_filter->handleRequest($request);
        //Filtros
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($pedido->getFechadesde()){
                $queryBuilder->andWhere('bp.fecha >= :fechadesde')
                             ->setParameter('fechadesde',  $pedido->getFechadesde());   
            }
            if ($pedido->getFechahasta()){
                $queryBuilder->andWhere('bp.fecha <= :fechahasta')
                             ->setParameter('fechahasta',  $pedido->getFechahasta());   
            }
             if ($pedido->getEstadoId()){
                $queryBuilder->andWhere('bp.estadoId = :estadoid')
                             ->setParameter('estadoid',  $pedido->getEstadoId());   
            }
        }
        
        $registros = $queryBuilder;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),8);
        
        return $this->render('pedido/pedidos_hoy.html.twig', array(
            'pagination' => $pagination, 
            'form_filter'=>$form_filter->createView(), 'hoy'=>$hoy,
            'estados'=> GlobalValue::ESTADOS
        ));
    }
    

    /**
     * Creates a new pedido entity.
     *
     * @Route("/new", name="pedido_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pedido = new Pedido();
        /* Crea Formulario */
        $form = $this->createForm('AppBundle\Form\PedidoType', $pedido);
        $form->add('empleado', EntityType::class, array(
                        'class' => 'AppBundle:Empleado',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'TextoCombo'))
                ->add('cliente', EntityType::class, array(
                        'class' => 'AppBundle:Cliente',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.contacto', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'textocombo'
                    ));
                
                        
        $form->handleRequest($request);
        
        /* Guardar datos */          
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pedido->setEmpresa($this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
            $pedido->setEstadoId(GlobalValue::PENDIENTE);
            $em->persist($pedido);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('pedidodetalle_new', array('pedido_id' => $pedido->getId()));
        }

        return $this->render('pedido/new.html.twig', array(
            'pedido' => $pedido,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pedido entity.
     *
     * @Route("/{id}", name="pedido_show")
     * @Method("GET")
     */
    public function showAction(Pedido $pedido)
    {
        $deleteForm = $this->createDeleteForm($pedido);

        return $this->render('pedido/show.html.twig', array(
            'pedido' => $pedido,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pedido entity.
     *
     * @Route("/{id}/edit", name="pedido_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pedido $pedido)
    {
        $deleteForm = $this->createDeleteForm($pedido);
        $editForm = $this->createForm('AppBundle\Form\PedidoType', $pedido);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('pedido_edit', array('id' => $pedido->getId()));
        }

        return $this->render('pedido/edit.html.twig', array(
            'pedido' => $pedido,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pedido entity.
     *
     * @Route("/{id}", name="pedido_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pedido $pedido)
    {
        $form = $this->createDeleteForm($pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pedido);
            $em->flush();
        }

        return $this->redirectToRoute('pedido_index');
    }

    /**
     * Creates a form to delete a pedido entity.
     *
     * @param Pedido $pedido The pedido entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pedido $pedido)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedido_delete', array('id' => $pedido->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
