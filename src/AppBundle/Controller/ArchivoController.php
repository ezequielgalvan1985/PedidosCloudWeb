<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archivo;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Empresa;
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
            'archivo_estados'=> GlobalValue::ARCHIVO_ESTADOS,
            'archivo_tipos'=>GlobalValue::ARCHIVO_TIPOS
        ));
    }

    
    public function procesarArchivo(Empresa $empresa, Archivo $archivo)
    {

        $csv = array();
        $path = $this->getParameter('archivos_productos_path');
        $pathfilename = $path . $archivo->getArchivo();
        $lines = file($pathfilename, FILE_IGNORE_NEW_LINES);
        
        // agregar funcion validar estructura validarEstructura($pathfilename, $tipoarchivo)
        // agregar funcion convertFileToArray
        // agregar funciones importProductos(arrayFile)
        // Pasa todo a un array
        foreach ($lines as $key => $value)
        {
            $csv[$key] = str_getcsv($value);
        }
        $em = $this->getDoctrine()->getManager();
        if ($archivo->getTipo() == GlobalValue::ARCHIVO_PRODUCTOS){
            $fileindex = 0; $header = 0;//Variable para identificar cabecera
            foreach ($csv as $record)
            {
                if ($fileindex > $header){
                    
                    $producto = new Producto();
                    //validar si existe producto
                    $producto->setCodigoexterno($record[4]);   
                    $producto->setNombre($record[1]);
                    $producto->setDescripcion($record[2]);
                    $producto->setPrecio($record[3]); 
                    
                    $producto->setEmpresa($empresa);
                    $em->persist($producto);
                    $em->flush();
                }
                $fileindex = $fileindex +1;
            }
            print_r($csv);
            $data = $csv;
            
            $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_PROCESADO);
            $em->persist($archivo);
            $em->flush();
        
        }
        
        
        
        
        
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
            
            try{
                $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
                $file = $archivo->getArchivo();
                $fileName = md5(uniqid()).'.csv';
                $file->move($this->getParameter('archivos_productos_path'), $fileName);
                $archivo->setArchivo($fileName);
                $archivo->setEstado(GlobalValue::ARCHIVO_ESTADO_UPLOAD);
                $hoy = date("Y-m-d");
                $archivo->setFecha($hoy);
                //Obtener Empresa
                $archivo->setEmpresa($empresa);
                $em = $this->getDoctrine()->getManager();
                $em->persist($archivo);
                $em->flush();
                
                $this->procesarArchivo($empresa, $archivo );
                
            
            
            
                $this->addFlash(  'success','Guardado y rpocesadoCorrectamente!');
                return $this->redirectToRoute('archivo_show', array('id' => $archivo->getId()));
            }catch(Exception $e){
                $output->writeln("WARNING: ArchivoController." + $e->getMessage());
                  
            }
            return $this->redirectToRoute('archivo_index');
        }

        return $this->render('archivo/new.html.twig', array(
            'archivo' => $archivo,
            'form' => $form->createView(),
            'archivo_estados'=> GlobalValue::ARCHIVO_ESTADOS,
            'archivo_tipos'=>GlobalValue::ARCHIVO_TIPOS
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
            'archivo_estados'=> GlobalValue::ARCHIVO_ESTADOS,
            'archivo_tipos'=>GlobalValue::ARCHIVO_TIPOS
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
