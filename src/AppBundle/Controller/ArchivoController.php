<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archivo;
use AppBundle\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\FileUploader;
use AppBundle\Entity\GlobalValue;

/**
 * Archivo controller.
 *
 * @Route("archivo")
 */
class ArchivoController extends Controller
{
    /**
     * Lists all categorium entities.
     *
     * @Route("/", name="archivo_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        
        //Obtener empresa
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        
        //Crear formulario de filtro
        $archivo = new Archivo();
        $form_filter = $this->createForm('AppBundle\Form\ArchivoFilterType', $archivo);
        $form_filter->handleRequest($request);

        $queryBuilder = $this->getDoctrine()->getRepository(Archivo::class)
                ->createQueryBuilder('bp')
                ->where('bp.empresa = :empresa')
                ->setParameter('empresa', $empresa);
                     
         
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($archivo->getNombre()){
                $queryBuilder->andWhere('bp.nombre LIKE :nombre')
                             ->setParameter('nombre', '%'. $archivo->getNombre(). '%');   
            }
            if($archivo->getDescripcion()){
                $queryBuilder->andWhere('bp.descripcion LIKE :descripcion')
                             ->setParameter('descripcion', '%'. $archivo->getDescripcion(). '%');
            }
            
            if($archivo->getTipo()){
                $queryBuilder->andWhere('bp.tipo = :tipo')
                             ->setParameter('tipo',  $archivo->getTipo());
            }
            
        }
        $archivos = $queryBuilder;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($archivos, $request->query->getInt('page', 1),10);

        return $this->render('archivo/index.html.twig', array(
            'pagination' => $pagination, 
            'form_filter'=>$form_filter->createView(),
            'estados'=> GlobalValue::ARCHIVO_ESTADOS,
            'tipos'=>GlobalValues::ARCHIVO_TIPOS
        ));
    }

    /**
     * Creates a new categorium entity.
     *
     * @Route("/new", name="archivo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $archivo = new Archivo();
        $form = $this->createForm('AppBundle\Form\ArchivoType', $archivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $file = $archivo->getArchivo();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('archivos_productos_path'), $fileName);
            $archivo->setArchivo($fileName);
            $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_ERROR_UPLOAD);
            //Obtener Empresa
            $archivo->setEmpresa($this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
            $em = $this->getDoctrine()->getManager();
            $em->persist($archivo);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('archivo_show', array('id' => $archivo->getId()));
        }

        return $this->render('archivo/new.html.twig', array(
            'categorium' => $archivo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorium entity.
     *
     * @Route("/{id}", name="archivo_show")
     * @Method("GET")
     */
    public function showAction(Archivo $archivo)
    {   
        $deleteForm = $this->createDeleteForm($archivo);
        
        return $this->render('archivo/show.html.twig', array(
            'archivo' => $archivo,
            'delete_form' => $deleteForm->createView(),
            'estados'=> GlobalValue::ESTADOS
        ));
    }

    /**
     * Displays a form to edit an existing categorium entity.
     *
     * @Route("/{id}/edit", name="archivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Archivo $archivo)
    {
        $deleteForm = $this->createDeleteForm($archivo);
        $editForm = $this->createForm('AppBundle\Form\ArchivoType', $archivo);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$archivo->setImagen( new File($this->getParameter('images').'/'.$archivo->getImagen()));
            
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('archivo_edit', array('id' => $archivo->getId()));
        }

        return $this->render('archivo/edit.html.twig', array(
            'categorium' => $archivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorium entity.
     *
     * @Route("/{id}", name="archivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Archivo $archivo)
    {
        $form = $this->createDeleteForm($archivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($archivo);
            $em->flush();
        }

        return $this->redirectToRoute('archivo_index');
    }

    /**
     * Creates a form to delete a categorium entity.
     *
     * @param Archivo $archivo The categorium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Archivo $archivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('archivo_delete', array('id' => $archivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
