<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Archivo
 *
 * @ORM\Table(name="archivo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArchivoRepository")
 */
class Archivo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

   
    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="integer", length=2)
     */
    private $tipo;
    
    public function getTipo()
    {
        return $this->tipo;
    }
    
    
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="integer", length=2)
     */
    private $estado;
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }
    
    
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;
    
    public function getEmpresa()
    {
        return $this->empresa;
    }
    
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }
    
    
     /**
     *
     * @Assert\NotBlank(message="Please, upload the a Csv file.")
     * @Assert\File( maxSize = "100000000", mimeTypes= {"text/plain", "text/csv", "application/csv", "text/excel", "application/excel"}, mimeTypesMessage = "Please upload a valid CSV | exel file")
     */
    private $archivo;
    
    
    public function getArchivo()
    {
        return $this->archivo;
    }
    
    
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }
    

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Archivo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Archivo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

 
  
    
    
    
    
}

