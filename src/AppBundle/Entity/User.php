<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="users" )
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    
    protected $roles = array();
    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        // allows for chaining
        return $this;
    }
    
    
    
     /**
     * 
     * 
     */
    protected $enabled;
    
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }
    
    /**
    * Get username
    * @return  
    */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
    * Set username
    * @return $this
    */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
    * Get email
    * @return  
    */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
    * Set email
    * @return $this
    */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
    * Get emailCanonical
    * @return  
    */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }
    
    /**
    * Set emailCanonical
    * @return $this
    */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
        return $this;
    }
    
    /**
     * Get apitoken
     * @return  
     */
     public function getApitoken()
     {
         return $this->apitoken;
     }
     
     /**
     * Set apitoken
     * @return $this
     */
     public function setApitoken($apitoken)
     {
         $this->apitoken = $apitoken;
         return $this;
     }     
    
}