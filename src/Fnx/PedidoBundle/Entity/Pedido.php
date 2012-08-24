<?php

namespace Fnx\PedidoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fnx\PedidoBundle\Entity\Item as Item;

/**
 * Fnx\PedidoBundle\Entity\Pedido
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Fnx\PedidoBundle\Entity\PedidoRepository")
 */
class Pedido
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
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     */
    private $cliente;

    /**
     * @var datetime $data
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var date $previsao
     *
     * @ORM\Column(name="previsao", type="date")
     */
    private $previsao;
    
    /**
     * @var date $dataPagamento
     *
     * @ORM\Column(name="data_pagamento", type="date")
     */
    private $dataPagamento;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Item", mappedBy="pedido", fetch="LAZY")
     */
    private $itens;

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
     * Set data
     *
     * @param datetime $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    
    public function getCliente() {
        return $this->cliente;
    }

    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    
    
    public function getItens() {
        return $this->itens;
    }

    public function setItens($itens) {
        $this->itens = $itens;
    }

    /**
     * Get data
     *
     * @return datetime 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set previsao
     *
     * @param date $previsao
     */
    public function setPrevisao($previsao)
    {
        $this->previsao = $previsao;
    }

    /**
     * Get previsao
     *
     * @return date 
     */
    public function getPrevisao()
    {
        return $this->previsao;
    }
}