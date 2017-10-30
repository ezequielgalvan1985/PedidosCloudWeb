<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movimientostock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\GlobalValue;

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
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        //Obtener empresa
        $currentuser = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $currentuser->getEmpresa();
        
        //Crear formulario de filtro
        $movimientostock = new Movimientostock();
        $form_filter = $this->createForm('AppBundle\Form\MovimientostockFilterType', $movimientostock);
        $form_filter->handleRequest($request);

        $queryBuilder = $this->getDoctrine()->getRepository(Movimientostock::class)->createQueryBuilder('bp');
        $queryBuilder->where('bp.empresa = :empresa')->setParameter('empresa', $empresa);
                  
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
           
            if ($movimientostock->getNrocomprobante()){
                $queryBuilder->andWhere('bp.nrocomprobante = :nrocomprobante')
                             ->setParameter('nrocomprobante',  $movimientostock->getNrocomprobante());   
            }
            if($movimientostock->getTipomovimiento()){
                $queryBuilder->andWhere('bp.tipomovimiento = :tipomovimiento')
                             ->setParameter('tipomovimiento',  $movimientostock->getTipomovimiento());
            }
             if($movimientostock->getProducto()){
                $queryBuilder->andWhere('bp.producto = :producto')
                             ->setParameter('producto',  $movimientostock->getProducto());
            }
           
        }
          
        $registros = $queryBuilder;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),8);
        return $this->render('movimientostock/index.html.twig', array(
            'pagination' => $pagination,
            'form_filter'=> $form_filter->createView(),
            'tipomovimientos'=>GlobalValue::TIPOMOVIMIENTOS
        ));
    }
    
     /**
     * Creates a new cliente entity.
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
            //Obtener Empresa
            $movimientostock->setEmpresa($this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
            $em->persist($movimientostock);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('movimientostock_show', array('id' => $movimientostock->getId()));
        }

        return $this->render('movimientostock/new.html.twig', array(
            'movimientostock' => $movimientostock,
            'form' => $form->createView()
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
            'tipomovimientos'=>GlobalValue::TIPOMOVIMIENTOS
        ));
    }
    

    
    
    /**
     * Lists all movimientostock entities.
     *
     * @Route("/existencias/", name="movimientostock_existencias")
     * @Method({"GET", "POST"})
     */
    public function existenciasAction(Request $request)
    {
        //Obtener empresa
        $currentuser = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $currentuser->getEmpresa();
        
        //Crear formulario de filtro
        $movimientostock = new Movimientostock();
        $form_filter = $this->createForm('AppBundle\Form\MovimientostockFilterType', $movimientostock);
        $form_filter->handleRequest($request);
/*
        $queryBuilder = $this->getDoctrine()
                ->getRepository(Movimientostock::class)
                ->createQueryBuilder('bp');
        $queryBuilder->where('bp.empresa = :empresa')->setParameter('empresa', $empresa);
                  
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
           
            if ($movimientostock->getNrocomprobante()){
                $queryBuilder->andWhere('bp.nrocomprobante = :nrocomprobante')
                             ->setParameter('nrocomprobante',  $movimientostock->getNrocomprobante());   
            }
            if($movimientostock->getTipomovimiento()){
                $queryBuilder->andWhere('bp.tipomovimiento = :tipomovimiento')
                             ->setParameter('tipomovimiento',  $movimientostock->getTipomovimiento());
            }
             if($movimientostock->getProducto()){
                $queryBuilder->andWhere('bp.producto = :producto')
                             ->setParameter('producto',  $movimientostock->getProducto());
            }
           
        }
        * 
        */
        $registros = $this->getDoctrine()->getManager()
                //->getRepository('AppBundle:Movimientostock')
                //->createQueryBuilder('m')
                ->createQuery("SELECT 
                                p.nombre, 
                                 (select sum(m1.cantidad) FROM AppBundle:Movimientostock m1 where m1.tipomovimiento = 1 and m1.producto = p) as ingreso ,
                                 (select sum(m2.cantidad) FROM AppBundle:Movimientostock m2 where  m2.tipomovimiento = 2 and m2.producto = p) as egreso
                                
                                FROM AppBundle:Producto p
                                WHERE p.empresa = :empresa
                                ")
                 
                //->groupBy('m.producto')
                ->setParameter('empresa', $empresa)
                //->getQuery()
                ->getResult();
                
                
                /*
                        . 'p.nombre as nombre, '
                        . 'p.precio as precio, '
                        . ' case m.tipomovimiento when 1 then sum(m.cantidad) else sum(m.cantidad *-1) end case as existencias '
                        . 'FROM AppBundle:Movimientostock as m '
                        . 'INNER JOIN AppBundle:Producto as p on m.producto_id = p.id '
                        . 'WHERE m.empresa = '. $empresa
                        . 'GROUP BY m.producto_id'); 
        */
                
                
        //$paginator  = $this->get('knp_paginator');
        //$pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),8);
        return $this->render('movimientostock/existencias.html.twig', array(
            'pagination' => $registros,
            'form_filter'=> $form_filter->createView(),
            'tipomovimientos'=>GlobalValue::TIPOMOVIMIENTOS
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
            $this->addFlash(  'success','Guardado Correctamente!');
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
