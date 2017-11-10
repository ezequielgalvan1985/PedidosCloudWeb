<?php

namespace AppBundle\Entity;



use Symfony\Component\Validator\Constraints as Assert;



class ArchivoFilter
{
    
    
    
  
  
    private $id;

   
    private $nombre;

    
    private $descripcion;

    
    private $fecha;
    
    
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    
    public function getFecha()
    {
        return $this->fecha;
    }
    
    
    
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
    
    

    public function getId()
    {
        return $this->id;
    }
    
    

   
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

