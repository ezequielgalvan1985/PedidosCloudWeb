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
     * @var string
     *
     * @ORM\Column(name="comprobante_nro", type="string", length=50)
     */
    private $comprobanteNro;


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
     * Set comprobanteNro
     *
     * @param string $comprobanteNro
     *
     * @return Movimientostock
     */
    public function setComprobanteNro($comprobanteNro)
    {
        $this->comprobanteNro = $comprobanteNro;

        return $this;
    }

    /**
     * Get comprobanteNro
     *
     * @return string
     */
    public function getComprobanteNro()
    {
        return $this->comprobanteNro;
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
    

}

