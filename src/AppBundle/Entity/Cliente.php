<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClienteRepository")
 */
class Cliente
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
     * @ORM\Column(name="razonsocial", type="string", length=50)
     */
    private $razonsocial;

    /**
     * @var string
     *
     * @ORM\Column(name="contacto", type="string", length=50, nullable=true)
     */
    private $contacto;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="tipodoc", type="string", length=20, nullable=true)
     */
    private $tipodoc;
    

    /**
     * @var string
     *
     * @ORM\Column(name="ndoc", type="string", length=20, nullable=true)
     */
    private $ndoc;


    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=50, nullable=true)
     */
    private $web;
    
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
    * Get contacto
    * @return  
    */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
    * Set contacto
    * @return $this
    */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;
        return $this;
    }

    /**
    * Get razonsocial
    * @return  
    */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }
    
    /**
    * Set razonsocial
    * @return $this
    */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;
        return $this;
    }
    /**
    * Get tipodoc
    * @return  
    */
    public function getTipodoc()
    {
        return $this->tipodoc;
    }
    
    /**
    * Set tipodoc
    * @return $this
    */
    public function setTipodoc($tipodoc)
    {
        $this->tipodoc = $tipodoc;
        return $this;
    }


    /**
    * Get web
    * @return  
    */
    public function getWeb()
    {
        return $this->web;
    }
    
    /**
    * Set web
    * @return $this
    */
    public function setWeb($web)
    {
        $this->web = $web;
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

   
   
   

    /**
     * Set ndoc
     *
     * @param string $ndoc
     *
     * @return Cliente
     */
    public function setNdoc($ndoc)
    {
        $this->ndoc = $ndoc;

        return $this;
    }

    /**
     * Get ndoc
     *
     * @return string
     */
    public function getNdoc()
    {
        return $this->ndoc;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Cliente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Cliente
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Cliente
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
    
    public function getTextoCombo(){
         return $this->contacto ;
    }
}

