<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tipodocumento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tipodocumento controller.
 *
 * @Route("tipodocumento")
 */
class TipodocumentoController extends Controller
{
    /**
     * Lists all tipodocumento entities.
     *
     * @Route("/", name="tipodocumento_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
       //Obtener empresa
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        
        //Crear formulario de filtro
        $tipodocumento = new Tipodocumento();
        $form_filter = $this->createForm('AppBundle\Form\TipodocumentoFilterType', $tipodocumento);
        $form_filter->handleRequest($request);

        $queryBuilder = $this->getDoctrine()->getRepository(Tipodocumento::class)->createQueryBuilder('bp');
        $queryBuilder->where('bp.empresa = :empresa')->setParameter('empresa', $empresa);
                     
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($tipodocumento->getNombre()){
                $queryBuilder->andWhere('bp.nombre LIKE :nombre')
                             ->setParameter('nombre', '%'. $tipodocumento->getNombre(). '%');   
            }
            if($tipodocumento->getDescripcion()){
                $queryBuilder->andWhere('bp.descripcion LIKE :descripcion')
                             ->setParameter('descripcion', '%'. $tipodocumento->getDescripcion(). '%');
            }
        }
        $registros = $queryBuilder;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),10);


        return $this->render('tipodocumento/index.html.twig', array(
            'pagination' => $pagination, 'form_filter' => $form_filter->createView()
        ));
    }

    /**
     * Creates a new tipodocumento entity.
     *
     * @Route("/new", name="tipodocumento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipodocumento = new Tipodocumento();
        $form = $this->createForm('AppBundle\Form\TipodocumentoType', $tipodocumento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tipodocumento->setEmpresa($this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
            $em->persist($tipodocumento);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('tipodocumento_show', array('id' => $tipodocumento->getId()));
        }

        return $this->render('tipodocumento/new.html.twig', array(
            'tipodocumento' => $tipodocumento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tipodocumento entity.
     *
     * @Route("/{id}", name="tipodocumento_show")
     * @Method("GET")
     */
    public function showAction(Tipodocumento $tipodocumento)
    {
        $deleteForm = $this->createDeleteForm($tipodocumento);

        return $this->render('tipodocumento/show.html.twig', array(
            'tipodocumento' => $tipodocumento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tipodocumento entity.
     *
     * @Route("/{id}/edit", name="tipodocumento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tipodocumento $tipodocumento)
    {
        $deleteForm = $this->createDeleteForm($tipodocumento);
        $editForm = $this->createForm('AppBundle\Form\TipodocumentoType', $tipodocumento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('tipodocumento_edit', array('id' => $tipodocumento->getId()));
        }

        return $this->render('tipodocumento/edit.html.twig', array(
            'tipodocumento' => $tipodocumento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tipodocumento entity.
     *
     * @Route("/{id}", name="tipodocumento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tipodocumento $tipodocumento)
    {
        $form = $this->createDeleteForm($tipodocumento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipodocumento);
            $em->flush();
        }

        return $this->redirectToRoute('tipodocumento_index');
    }

    /**
     * Creates a form to delete a tipodocumento entity.
     *
     * @param Tipodocumento $tipodocumento The tipodocumento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipodocumento $tipodocumento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipodocumento_delete', array('id' => $tipodocumento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
