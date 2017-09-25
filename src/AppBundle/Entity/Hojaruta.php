<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Hojaruta
 *
 * @ORM\Table(name="hojaruta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HojarutaRepository")
 */
class Hojaruta
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
     * @var int
     *
     * @ORM\Column(name="dia_id", type="integer")
     */
    private $diaId;

    

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="notas", type="string", length=255, nullable=true)
     */
    private $notas;

    /**
    * @ORM\OneToMany(targetEntity="Hojarutadetalle", mappedBy="hojaruta")
    */
    private $hojarutadetalles;

    public function __construct()
    {
        $this->hojarutadetalles = new ArrayCollection();
    }
    
    public function getHojarutadetalles(){
        return $this->hojarutadetalles;
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
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     */
    private $empleado;
    
    public function getEmpleado()
    {
        return $this->empleado;
    }
    
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
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
     * Set diaId
     *
     * @param integer $diaId
     *
     * @return Hojaruta
     */
    public function setDiaId($diaId)
    {
        $this->diaId = $diaId;

        return $this;
    }

    /**
     * Get diaId
     *
     * @return int
     */
    public function getDiaId()
    {
        return $this->diaId;
    }

    
    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Hojaruta
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set notas
     *
     * @param string $notas
     *
     * @return Hojaruta
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;

        return $this;
    }

    /**
     * Get notas
     *
     * @return string
     */
    public function getNotas()
    {
        return $this->notas;
    }
}

