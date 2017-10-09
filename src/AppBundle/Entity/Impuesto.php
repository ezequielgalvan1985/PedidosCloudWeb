<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Impuesto
 *
 * @ORM\Table(name="impuesto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImpuestoRepository")
 */
class Impuesto
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
     * @ORM\Column(name="alicuota", type="decimal", precision=7, scale=3)
     */
    private $alicuota;

    /**
     * @var int
     *
     * @ORM\Column(name="tipoiva", type="integer")
     */
    private $tipoiva;

    /**
     * @var int
     *
     * @ORM\Column(name="condicion", type="integer")
     */
    private $condicion;

    /**
     * @var int
     *
     * @ORM\Column(name="codigoafip", type="integer", nullable=true)
     */
    private $codigoafip;



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
     * @return Impuesto
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
     * Set alicuota
     *
     * @param string $alicuota
     *
     * @return Impuesto
     */
    public function setAlicuota($alicuota)
    {
        $this->alicuota = $alicuota;

        return $this;
    }

    /**
     * Get alicuota
     *
     * @return string
     */
    public function getAlicuota()
    {
        return $this->alicuota;
    }

    /**
     * Set tipoiva
     *
     * @param integer $tipoiva
     *
     * @return Impuesto
     */
    public function setTipoiva($tipoiva)
    {
        $this->tipoiva = $tipoiva;

        return $this;
    }

    /**
     * Get tipoiva
     *
     * @return int
     */
    public function getTipoiva()
    {
        return $this->tipoiva;
    }

    /**
     * Set condicion
     *
     * @param integer $condicion
     *
     * @return Impuesto
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return int
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * Set codigoafip
     *
     * @param integer $codigoafip
     *
     * @return Impuesto
     */
    public function setCodigoafip($codigoafip)
    {
        $this->codigoafip = $codigoafip;

        return $this;
    }

    /**
     * Get codigoafip
     *
     * @return int
     */
    public function getCodigoafip()
    {
        return $this->codigoafip;
    }
}

