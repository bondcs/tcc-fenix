<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fnx\AdminBundle\Entity\ServicoAdmin
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ServicoAdmin
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
     * @var string $descricao
     *
     * @ORM\Column(name="descricao", type="string", length=80)
     * @Assert\NotBlank()
     */
    private $descricao;

    /**
     * @var float $valor
     *
     * @ORM\Column(name="valor", type="float")
     * @Assert\NotBlank()
     */
    private $valor;
    
    /**
     *
     * @var object $fornecedor
     * @ORM\ManyToOne(targetEntity="Fornecedor", cascade={"persist"}, fetch="LAZY")
     */
    private $fornecedor;
    
    /**
     *
     * @var Objetc $atividade
     * 
     * @ORM\ManyToOne(targetEntity="Atividade", inversedBy="servicos", cascade={"persist"}, fetch="LAZY")
     */
    private $atividade;

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
     * Set valor
     *
     * @param float $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * Get valor
     *
     * @return float 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set fornecedor
     *
     * @param Fnx\AdminBundle\Entity\Fornecedor $fornecedor
     */
    public function setFornecedor(\Fnx\AdminBundle\Entity\Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    /**
     * Get fornecedor
     *
     * @return Fnx\AdminBundle\Entity\Fornecedor 
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
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
}