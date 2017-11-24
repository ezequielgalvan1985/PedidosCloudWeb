<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movimientostock;
use AppBundle\Entity\Producto;
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
           
            if($movimientostock->getFechadesde()){
                $queryBuilder->andWhere('bp.fecha >= :fechadesde')
                             ->setParameter('fechadesde',  $movimientostock->getFechadesde());
            }
            if($movimientostock->getFechahasta()){
                $queryBuilder->andWhere('bp.fecha <= :fechahasta')
                             ->setParameter('fechahasta',  $movimientostock->getFechaHasta());
            }
            if($movimientostock->getTipomovimiento()){
                $queryBuilder->andWhere('bp.tipomovimiento = :tipomovimiento')
                             ->setParameter('tipomovimiento',  $movimientostock->getTipomovimiento());
            }
            /*
            if($movimientostock->getCodigoexterno()){
                $queryBuilder->andWhere('bp.producto[''] = :codigoexterno')
                             ->setParameter('codigoexterno',  $movimientostock->getCodigoexterno());
            }
             * 
             */
            
            if($movimientostock->getProducto()){
                $queryBuilder->andWhere('bp.producto = :producto')
                             ->setParameter('producto',  $movimientostock->getProducto());
            }
           
        }
          
        $registros = $queryBuilder;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),50);
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

            //Actualizar campo stock dentro de producto
            $p = new Producto();
            if ($movimientostock->getTipomovimiento()== GlobalValue::INGRESO){
                $p = $movimientostock->getProducto();
                $p->setStock($p->getStock() + $movimientostock->getCantidad());
            }
            if ($movimientostock->getTipomovimiento()== GlobalValue::EGRESO){
                $p = $movimientostock->getProducto();
                $p->setStock($p->getStock() - $movimientostock->getCantidad());
            }
            if ($movimientostock->getTipomovimiento()== GlobalValue::INICIALIZACION){
                $p = $movimientostock->getProducto();
                $p->setStock($movimientostock->getCantidad());
            }
            $em->persist($movimientostock);
            $em->persist($p);
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
