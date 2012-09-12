<?php

namespace Fnx\AdminBundle\Entity;
use Fnx\AdminBundle\Entity\Atividade;
use Fnx\AdminBundle\Entity\Funcionario;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fnx\AdminBundle\Entity\Escala
 *
 * @ORM\Table(name="escala")
 * @ORM\Entity(repositoryClass="Fnx\AdminBundle\Entity\EscalaRepository")
 */
class Escala
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
     * @var datetime $dtInicio
     *
     * @ORM\Column(name="dtInicio", type="datetime")
     * @Assert\NotBlank()
     */
    private $dtInicio;

    /**
     * @var datetime $dtFim
     *
     * @ORM\Column(name="dtFim", type="datetime")
     * @Assert\NotBlank()
     */
    private $dtFim;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Atividade", inversedBy="escalas", cascade={"persist"}, fetch="LAZY")
     */
    private $atividade;
    
    /**
     * 
     * @ORM\ManyToMany(targetEntity="Funcionario", inversedBy="escalas", cascade={"persist"})
     * @ORM\JoinTable(name="escala_funcionario",
     *     joinColumns={@ORM\JoinColumn(name="escala_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="funcionario_id", referencedColumnName="id")}
     * )
     * 
     */
    private $funcionarios;
    
    public function __construct() {
        $this->funcionarios = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dtInicio
     *
     * @param datetime $dtInicio
     */
    public function setDtInicio($dtInicio)
    {
        $this->dtInicio = $dtInicio;
    }

    /**
     * Get dtInicio
     *
     * @return datetime 
     */
    public function getDtInicio()
    {      
        return $this->dtInicio;
    }

    /**
     * Set dtFim
     *
     * @param datetime $dtFim
     */
    public function setDtFim($dtFim)
    {
        $this->dtFim = $dtFim;
    }

    /**
     * Get dtFim
     *
     * @return datetime 
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * Set atividade
     *
     * @param Fnx\AdminBundle\Entity\Atividade $atividade
     */
    public function setAtividade(\Fnx\AdminBundle\Entity\Atividade $atividade)
    {
        $this->atividade = $atividade;
    }

    /**
     * Get atividade
     *
     * @return Fnx\AdminBundle\Entity\Atividade 
     */
    public function getAtividade()
    {
        return $this->atividade;
    }

    /**
     * Add funcionarios
     *
     * @param Fnx\AdminBundle\Entity\Funcionario $funcionarios
     */
    public function addFuncionario(\Fnx\AdminBundle\Entity\Funcionario $funcionarios)
    {
        $this->funcionarios[] = $funcionarios;
    }

    /**
     * Get funcionarios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFuncionarios()
    {
        return $this->funcionarios;
    }
}