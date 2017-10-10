<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidodetalle
 *
 * @ORM\Table(name="pedidodetalle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidodetalleRepository")
 */
class Pedidodetalle
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
     * @ORM\Column(name="cantidad", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="preciounitario", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $preciounitario;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $monto;

    /**
    * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="pedidodetalles")
    * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
    */
    private $pedido;
    
    
    public function getPedido()
    {
        return $this->pedido;
    }
    
    
    public function setPedido($pedido)
    {
        $this->pedido = $pedido;

        return $this;
    }
    
    
    /**
    * @ORM\ManyToOne(targetEntity="Producto")
    * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
    */
    private $producto;
    
    
    public function getProducto()
    {
        return $this->producto;
    }
    
    
    public function setProducto($producto)
    {
        $this->producto = $producto;

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
     * Set cantidad
     *
     * @param string $cantidad
     *
     * @return Pedidodetalle
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
     * Set preciounitario
     *
     * @param string $preciounitario
     *
     * @return Pedidodetalle
     */
    public function setPreciounitario($preciounitario)
    {
        $this->preciounitario = $preciounitario;

        return $this;
    }

    /**
     * Get preciounitario
     *
     * @return string
     */
    public function getPreciounitario()
    {
        return $this->preciounitario;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return Pedidodetalle
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

