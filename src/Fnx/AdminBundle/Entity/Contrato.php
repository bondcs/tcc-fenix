<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fnx\AdminBundle\Entity\Cliente;

/**
 * Fnx\AdminBundle\Entity\Contrato
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fnx\AdminBundle\Entity\ContratoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Contrato
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
     /**
     * @var datetime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;
    
    /**
     * @Column(name="arquivado",type="boolean", nullable=false)
     * @var boolean $ativo
     */
    private $arquivado;
    
    /**
     * @var object $cliente
     * 
     * @ORM\ManyToOne(targetEntity="Cliente", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;
    
    
    public function __construct() {
        $this->created = new \DateTime();
        $this->arquivado = false;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }
    
    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue(){
        $this->updated = new \datetime();
        
    }
}