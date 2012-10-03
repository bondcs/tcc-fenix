<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fnx\AdminBundle\Entity\EscalaFun
 *
 * @ORM\Table(name="escalaFun")
 * @ORM\Entity(repositoryClass="Fnx\AdminBundle\Entity\EscalaFunRepository")
 */
class EscalaFun
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
     * @var datetime $inicio
     *
     * @ORM\Column(name="inicio", type="datetime")
     * @Assert\NotBlank()
     */
    private $inicio;

    /**
     * @var datetime $fim
     *
     * @ORM\Column(name="fim", type="datetime")
     * @Assert\NotBlank()
     */
    private $fim;

    /**
     * @var string $descricao
     *
     * @ORM\Column(name="descricao", type="string", length=80)
     * @Assert\NotBlank()
     * @Assert\MaxLength(60)
     */
    private $descricao;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Funcionario", cascade={"persist"}, fetch="LAZY")
     * @Assert\NotBlank()
     */
    private $funcionario;

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
     * Set inicio
     *
     * @param datetime $inicio
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
    }

    /**
     * Get inicio
     *
     * @return datetime 
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fim
     *
     * @param datetime $fim
     */
    public function setFim($fim)
    {
        $this->fim = $fim;
    }

    /**
     * Get fim
     *
     * @return datetime 
     */
    public function getFim()
    {
        return $this->fim;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set funcionario
     *
     * @param Fnx\AdminBundle\Entity\Funcionario $funcionario
     */
    public function setFuncionario(\Fnx\AdminBundle\Entity\Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
    }

    /**
     * Get funcionario
     *
     * @return Fnx\AdminBundle\Entity\Funcionario 
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }
}