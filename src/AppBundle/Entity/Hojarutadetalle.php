<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hojarutadetalle
 *
 * @ORM\Table(name="hojarutadetalle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HojarutadetalleRepository")
 */
class Hojarutadetalle
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
     * @ORM\Column(name="hora", type="datetime", nullable=true)
     */
    private $hora;

    /**
     * @var string
     *
     * @ORM\Column(name="notas", type="string", length=255, nullable=true)
     */
    private $notas;
    
    
     /**
     * @ORM\ManyToOne(targetEntity="Hojaruta", inversedBy="hojarutadetalles")
     * @ORM\JoinColumn(name="hojaruta_id", referencedColumnName="id")
     */
    private $hojaruta;
    
    
    public function getHojaruta()
    {
        return $this->hojaruta;
    }
    
    
    public function setHojaruta($hojaruta)
    {
        $this->hojaruta = $hojaruta;

        return $this;
    }
    
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;
    
    
    public function getCliente()
    {
        return $this->cliente;
    }
    
    
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
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
     * Set hora
     *
     * @param string $hora
     *
     * @return Hojarutadetalle
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return string
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set notas
     *
     * @param string $notas
     *
     * @return Hojarutadetalle
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

