<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
/**
 * Categoria controller.
 *
 * @Route("categoria")
 */
class CategoriaController extends Controller
{
    /**
     * Lists all categorium entities.
     *
     * @Route("/", name="categoria_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Categoria::class);
        //Obtener empresa
        $currentuser = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $currentuser->getEmpresa();
        $categorias = $repository->findByEmpresa($empresa);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($categorias, $request->query->getInt('page', 1),10);

        return $this->render('categoria/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new categorium entity.
     *
     * @Route("/new", name="categoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categoria = new Categoria();
        $form = $this->createForm('AppBundle\Form\CategoriaType', $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $categoria->getImagen();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('categorias_images'),$fileName);
            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $categoria->setImagen($fileName);
            //Obtener Empresa
            $categoria->setEmpresa($this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria);
            $em->flush();

            return $this->redirectToRoute('categoria_show', array('id' => $categoria->getId()));
        }

        return $this->render('categoria/new.html.twig', array(
            'categorium' => $categoria,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorium entity.
     *
     * @Route("/{id}", name="categoria_show")
     * @Method("GET")
     */
    public function showAction(Categoria $categoria)
    {   
        $categoria->setDirImagen($this->getParameter('categorias_images'));
        $deleteForm = $this->createDeleteForm($categoria);
        
        return $this->render('categoria/show.html.twig', array(
            'categorium' => $categoria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorium entity.
     *
     * @Route("/{id}/edit", name="categoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categoria $categoria)
    {
        $deleteForm = $this->createDeleteForm($categoria);
        $editForm = $this->createForm('AppBundle\Form\CategoriaType', $categoria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoria_edit', array('id' => $categoria->getId()));
        }

        return $this->render('categoria/edit.html.twig', array(
            'categorium' => $categoria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorium entity.
     *
     * @Route("/{id}", name="categoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Categoria $categoria)
    {
        $form = $this->createDeleteForm($categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categoria);
            $em->flush();
        }

        return $this->redirectToRoute('categoria_index');
    }

    /**
     * Creates a form to delete a categorium entity.
     *
     * @param Categoria $categoria The categorium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categoria $categoria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_delete', array('id' => $categoria->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
