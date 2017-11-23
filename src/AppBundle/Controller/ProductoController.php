<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


use League\Csv\Reader;
use League\Csv\Statement;

/**
 * Producto controller.
 *
 * @Route("producto")
 */
class ProductoController extends Controller
{
    /**
     * Lists all producto entities.
     *
     * @Route("/", name="producto_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        //Obtener empresa
        $currentuser = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $currentuser->getEmpresa();
        
        //Crear formulario de filtro
        $producto = new Producto();
        $form_filter = $this->createForm('AppBundle\Form\ProductoFilterType', $producto);
        $form_filter->add('categoria', EntityType::class, array(
                        'class' => 'AppBundle:Categoria', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'nombre'))
                    ->add('marca', EntityType::class, array(
                        'class' => 'AppBundle:Marca', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'nombre'));
        $form_filter->handleRequest($request);

        $queryBuilder = $this->getDoctrine()->getRepository(Producto::class)->createQueryBuilder('bp');
        $queryBuilder->where('bp.empresa = :empresa')->setParameter('empresa', $empresa);
                     
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($producto->getNombre()){
                $queryBuilder->andWhere('bp.nombre LIKE :nombre')
                             ->setParameter('nombre', '%'. $producto->getNombre(). '%');   
            }
            if($producto->getDescripcion()){
                $queryBuilder->andWhere('bp.descripcion LIKE :descripcion')
                             ->setParameter('descripcion', '%'. $producto->getDescripcion(). '%');
            }
            if($producto->getMarca()){
                $queryBuilder->andWhere('bp.marca = :marca')
                             ->setParameter('marca', $producto->getMarca());
            }
            if($producto->getCategoria()){
                $queryBuilder->andWhere('bp.categoria = :categoria')
                             ->setParameter('categoria', $producto->getCategoria());
            }
            if($producto->getCodigoexterno()){
                $queryBuilder->andWhere('bp.codigoexterno LIKE :codigoexterno')
                             ->setParameter('codigoexterno', '%'.$producto->getCodigoexterno(). '%');
            }
        }
        $productos = $queryBuilder;
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($productos, $request->query->getInt('page', 1),10);
        return $this->render('producto/index.html.twig', array(
            'pagination' => $pagination, 'form_filter'=>$form_filter->createView()
        ));
    }

    /**
     * Creates a new producto entity.
     *
     * @Route("/new", name="producto_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $producto = new Producto();
        $form = $this->createForm('AppBundle\Form\ProductoType', $producto);
        $form->add('categoria', EntityType::class, array(
                        'class' => 'AppBundle:Categoria', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'nombre'))
                    ->add('marca', EntityType::class, array(
                        'class' => 'AppBundle:Marca', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'nombre'));
                    
         
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $producto->setEmpresa($this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
            $em->persist($producto);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('producto_show', array('id' => $producto->getId()));
        }

        return $this->render('producto/new.html.twig', array(
            'producto' => $producto,
            'form' => $form->createView(),
        ));
    }
    
    
    

    /**
     * Finds and displays a producto entity.
     *
     * @Route("/{id}", name="producto_show")
     * @Method("GET")
     */
    public function showAction(Producto $producto)
    {
        $deleteForm = $this->createDeleteForm($producto);

        return $this->render('producto/show.html.twig', array(
            'producto' => $producto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing producto entity.
     *
     * @Route("/{id}/edit", name="producto_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Producto $producto)
    {
        $deleteForm = $this->createDeleteForm($producto);
        $editForm = $this->createForm('AppBundle\Form\ProductoType', $producto);
        $editForm->add('categoria', EntityType::class, array(
                        'class' => 'AppBundle:Categoria', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'nombre'))
                    ->add('marca', EntityType::class, array(
                        'class' => 'AppBundle:Marca', 
                        'required'=>false,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'nombre'))   ;
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('producto_edit', array('id' => $producto->getId()));
        }

        return $this->render('producto/edit.html.twig', array(
            'producto' => $producto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a producto entity.
     *
     * @Route("/{id}", name="producto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Producto $producto)
    {
        $form = $this->createDeleteForm($producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($producto);
            $em->flush();
        }

        return $this->redirectToRoute('producto_index');
    }

    /**
     * Creates a form to delete a producto entity.
     *
     * @param Producto $producto The producto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Producto $producto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producto_delete', array('id' => $producto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
