<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hojaruta;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\GlobalValue;

/**
 * Hojarutum controller.
 *
 * @Route("hojaruta")
 */
class HojarutaController extends Controller
{
    /**
     * Lists all hojaruta entities.
     *
     * @Route("/", name="hojaruta_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        //Obtener empresa
        $currentuser = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $currentuser->getEmpresa();
        
        //Crear formulario de filtro
        $hojaruta = new Hojaruta();
        $form_filter = $this->createForm('AppBundle\Form\HojarutaFilterType', $hojaruta);
        $form_filter->handleRequest($request);
        $queryBuilder = $this->getDoctrine()->getRepository(Hojaruta::class)->createQueryBuilder('bp');
        $queryBuilder->where('bp.empresa = :empresa')->setParameter('empresa', $empresa);
                     
        if ($form_filter->isSubmitted() && $form_filter->isValid()) {
            if ($hojaruta->getTitulo()){
                $queryBuilder->andWhere('bp.titulo LIKE :titulo')
                             ->setParameter('titulo', '%'. $hojaruta->getTitulo(). '%');   
            }
            if($hojaruta->getNotas()){
                $queryBuilder->andWhere('bp.notas LIKE :notas')
                             ->setParameter('notas', '%'. $hojaruta->getNotas(). '%');
            }
            if($hojaruta->getDiaId()){
                $queryBuilder->andWhere('bp.diaId = :dia')
                             ->setParameter('dia',  $hojaruta->getDiaId());
            }
        }
        $registros = $queryBuilder;
      
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($registros, $request->query->getInt('page', 1),10);

        return $this->render('hojaruta/index.html.twig', array(
              'pagination' => $pagination, 
              'form_filter'=>$form_filter->createView(),
              'dias'=> GlobalValue::DIAS_SEMANA
        ));
    }

    /**
     * Creates a new hojaruta entity.
     *
     * @Route("/new", name="hojaruta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hojaruta = new Hojaruta();
        $currentuser = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $currentuser->getEmpresa();
       
        //Formulario de Alta de Hoja de ruta
        $form = $this->createForm('AppBundle\Form\HojarutaType', $hojaruta);
        $form->add('empleado', EntityType::class, array(
                        'class' => 'AppBundle:Empleado',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->where('c.empresa = :empresa')
                                ->orderBy('c.nombre', 'DESC')
                                ->setParameter('empresa', $this->get('security.token_storage')->getToken()->getUser()->getEmpresa());
                        },
                        'choice_label' => 'TextoCombo'));
        $form->handleRequest($request);
        //Formulario de Alta de Hoja de ruta

        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Obtener Empresa
            $currentuser = $this->get('security.token_storage')->getToken()->getUser();
            $empresa = $currentuser->getEmpresa();
            $hojaruta->setEmpresa($empresa);
            
            $em->persist($hojaruta);
            $em->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            //redirigir a alta de detalle de hoja de ruta
            return $this->redirectToRoute('hojarutadetalle_new', array('hojaruta_id' => $hojaruta->getId()));
        }

        return $this->render('hojaruta/new.html.twig', array(
            'hojaruta' => $hojaruta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hojaruta entity.
     *
     * @Route("/{id}", name="hojaruta_show")
     * @Method("GET")
     */
    public function showAction(Hojaruta $hojaruta)
    {
        $deleteForm = $this->createDeleteForm($hojaruta);

        return $this->render('hojaruta/show.html.twig', array(
            'hojaruta' => $hojaruta,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hojaruta entity.
     *
     * @Route("/{id}/edit", name="hojaruta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hojaruta $hojaruta)
    {
        $deleteForm = $this->createDeleteForm($hojaruta);
        $editForm = $this->createForm('AppBundle\Form\HojarutaType', $hojaruta);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(  'success','Guardado Correctamente!');
            return $this->redirectToRoute('hojaruta_edit', array('id' => $hojaruta->getId()));
        }

        return $this->render('hojaruta/edit.html.twig', array(
            'hojaruta' => $hojaruta,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hojaruta entity.
     *
     * @Route("/{id}", name="hojaruta_delete")
     * @Method({"GET","DELETE"})
     */
    public function deleteAction(Request $request, Hojaruta $hojaruta)
    {
        $form = $this->createDeleteForm($hojaruta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hojaruta);
            $em->flush();
        }

        return $this->redirectToRoute('hojaruta_index');
    }

    /**
     * Creates a form to delete a hojaruta entity.
     *
     * @param Hojaruta $hojaruta The hojaruta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hojaruta $hojaruta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hojaruta_delete', array('id' => $hojaruta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
