<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Pedido
 *
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidoRepository")
 */
class Pedido
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
     * @ORM\Column(name="estado_id", type="integer")
     */
    private $estadoId;

    /**
     * @var int
     *
     * @ORM\Column(name="idtmp", type="integer", nullable=true)
     */
    private $idtmp;

    /**
     * @var string
     *
     * @ORM\Column(name="subtotal", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $subtotal;

    /**
     * @var string
     *
     * @ORM\Column(name="impuestos", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $impuestos;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $monto;
    
    
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
    * @ORM\OneToMany(targetEntity="Pedidodetalle", mappedBy="pedido")
    */
    private $pedidodetalles;

    public function __construct()
    {
        $this->pedidodetalles = new ArrayCollection();
    }
    
    public function getPedidodetalles(){
        return $this->pedidodetalles;
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
     * @return Pedido
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
     * Set estadoId
     *
     * @param integer $estadoId
     *
     * @return Pedido
     */
    public function setEstadoId($estadoId)
    {
        $this->estadoId = $estadoId;

        return $this;
    }

    /**
     * Get estadoId
     *
     * @return int
     */
    public function getEstadoId()
    {
        return $this->estadoId;
    }

    /**
     * Set idtmp
     *
     * @param integer $idtmp
     *
     * @return Pedido
     */
    public function setIdtmp($idtmp)
    {
        $this->idtmp = $idtmp;

        return $this;
    }

    /**
     * Get idtmp
     *
     * @return int
     */
    public function getIdtmp()
    {
        return $this->idtmp;
    }

    /**
     * Set subtotal
     *
     * @param string $subtotal
     *
     * @return Pedido
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get subtotal
     *
     * @return string
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set impuestos
     *
     * @param string $impuestos
     *
     * @return Pedido
     */
    public function setImpuestos($impuestos)
    {
        $this->impuestos = $impuestos;

        return $this;
    }

    /**
     * Get impuestos
     *
     * @return string
     */
    public function getImpuestos()
    {
        return $this->impuestos;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return Pedido
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }
    
    
    
    
}

