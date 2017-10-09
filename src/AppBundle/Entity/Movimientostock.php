<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movimientostock
 *
 * @ORM\Table(name="movimientostock")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovimientostockRepository")
 */
class Movimientostock
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="proveedor", type="integer")
     */
    private $proveedor;

    /**
     * @var string
     *
     * @ORM\Column(name="producto", type="string", length=10)
     */
    private $producto;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad", type="decimal", precision=7, scale=2)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="nrocomprobante", type="string", length=30, nullable=true)
     */
    private $nrocomprobante;

    /**
     * @var int
     *
     * @ORM\Column(name="tipomovimiento", type="integer")
     */
    private $tipomovimiento;



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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Movimientostock
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set proveedor
     *
     * @param integer $proveedor
     *
     * @return Movimientostock
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return int
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set producto
     *
     * @param string $producto
     *
     * @return Movimientostock
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return string
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set cantidad
     *
     * @param string $cantidad
     *
     * @return Movimientostock
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set nrocomprobante
     *
     * @param string $nrocomprobante
     *
     * @return Movimientostock
     */
    public function setNrocomprobante($nrocomprobante)
    {
        $this->nrocomprobante = $nrocomprobante;

        return $this;
    }

    /**
     * Get nrocomprobante
     *
     * @return string
     */
    public function getNrocomprobante()
    {
        return $this->nrocomprobante;
    }

    /**
     * Set tipomovimiento
     *
     * @param integer $tipomovimiento
     *
     * @return Movimientostock
     */
    public function setTipomovimiento($tipomovimiento)
    {
        $this->tipomovimiento = $tipomovimiento;

        return $this;
    }

    /**
     * Get tipomovimiento
     *
     * @return int
     */
    public function getTipomovimiento()
    {
        return $this->tipomovimiento;
    }
}

