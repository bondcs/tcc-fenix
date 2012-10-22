<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fnx\AdminBundle\Entity\Salario
 *
 * @ORM\Table(name="salario")
 * @ORM\Entity
 */
class Salario
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
     * @var float $salario
     *
     * @ORM\Column(name="salario", type="float")
     */
    private $salario;

    /**
     * @var float $salarioPago
     *
     * @ORM\Column(name="salarioPago", type="float")
     */
    private $salarioPago;

    /**
     * @var float $bonus
     *
     * @ORM\Column(name="bonus", type="float")
     */
    private $bonus;

    /**
     * @var float $valorHora
     *
     * @ORM\Column(name="valorHora", type="float")
     */
    private $valorHora;
    
    /**
     *
     * @var datetime $dataPagamento
     * 
     * @ORM\Column(name="dataPagamento", type="datetime")
     */
    private $dataPagamento;


    public function __construct() {
        $this->salarioPago = $this->salario;
        $this->dataPagamento = new \DateTime();
        $this->bonus = 0;
        
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
     * Set salario
     *
     * @param float $salario
     */
    public function setSalario($salario)
    {
        $this->salario = $salario;
    }

    /**
     * Get salario
     *
     * @return float 
     */
    public function getSalario()
    {
        return $this->salario;
    }

    /**
     * Set salarioPago
     *
     * @param float $salarioPago
     */
    public function setSalarioPago($salarioPago)
    {
        $this->salarioPago = $salarioPago;
    }

    /**
     * Get salarioPago
     *
     * @return float 
     */
    public function getSalarioPago()
    {
        return $this->salarioPago;
    }

    /**
     * Set bonus
     *
     * @param float $bonus
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;
    }

    /**
     * Get bonus
     *
     * @return float 
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set valorHora
     *
     * @param float $valorHora
     */
    public function setValorHora($valorHora)
    {
        $this->valorHora = $valorHora;
    }

    /**
     * Get valorHora
     *
     * @return float 
     */
    public function getValorHora()
    {
        return $this->valorHora;
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

    /**
     * Set dataPagamento
     *
     * @param datetime $dataPagamento
     */
    public function setDataPagamento($dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
    }

    /**
     * Get dataPagamento
     *
     * @return datetime 
     */
    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }
}