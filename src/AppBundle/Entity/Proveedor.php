<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor
 *
 * @ORM\Table(name="proveedor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProveedorRepository")
 */
class Proveedor
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
     * @ORM\Column(name="razonsocial", type="string", length=100)
     */
    private $razonsocial;

    /**
     * @var string
     *
     * @ORM\Column(name="domicilio", type="string", length=100, nullable=true)
     */
    private $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="percepcion", type="boolean")
     */
    private $percepcion;


    /**
     * @ORM\ManyToOne(targetEntity="Condicioniva")
     * @ORM\JoinColumn(name="condicioniva_id", referencedColumnName="id")
     */
    private $condicioniva;
    
    public function getCondicioniva()
    {
        return $this->condicioniva;
    }
    
    public function setCondicioniva($condicioniva)
    {
        $this->condicioniva = $condicioniva;
        return $this;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="cuit", type="string", length=30, nullable=true)
     */
    private $cuit;

    /**
     * @var string
     *
     * @ORM\Column(name="ingbrutos", type="string", length=50, nullable=true)
     */
    private $ingbrutos;

    /**
     * @var string
     *
     * @ORM\Column(name="codpostal", type="string", length=20, nullable=true)
     */
    private $codpostal;

    /**
     * @var string
     *
     * @ORM\Column(name="cbu", type="string", length=50, nullable=true)
     */
    private $cbu;


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
     * Set razonsocial
     *
     * @param string $razonsocial
     *
     * @return Proveedor
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return Proveedor
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Proveedor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set percepcion
     *
     * @param boolean $percepcion
     *
     * @return Proveedor
     */
    public function setPercepcion($percepcion)
    {
        $this->percepcion = $percepcion;

        return $this;
    }

    /**
     * Get percepcion
     *
     * @return bool
     */
    public function getPercepcion()
    {
        return $this->percepcion;
    }

    

    /**
     * Set cuit
     *
     * @param string $cuit
     *
     * @return Proveedor
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set ingbrutos
     *
     * @param string $ingbrutos
     *
     * @return Proveedor
     */
    public function setIngbrutos($ingbrutos)
    {
        $this->ingbrutos = $ingbrutos;

        return $this;
    }

    /**
     * Get ingbrutos
     *
     * @return string
     */
    public function getIngbrutos()
    {
        return $this->ingbrutos;
    }

    /**
     * Set codpostal
     *
     * @param string $codpostal
     *
     * @return Proveedor
     */
    public function setCodpostal($codpostal)
    {
        $this->codpostal = $codpostal;

        return $this;
    }

    /**
     * Get codpostal
     *
     * @return string
     */
    public function getCodpostal()
    {
        return $this->codpostal;
    }

    /**
     * Set cbu
     *
     * @param string $cbu
     *
     * @return Proveedor
     */
    public function setCbu($cbu)
    {
        $this->cbu = $cbu;

        return $this;
    }

    /**
     * Get cbu
     *
     * @return string
     */
    public function getCbu()
    {
        return $this->cbu;
    }
}

