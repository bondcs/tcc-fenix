<?php

namespace Fnx\PedidoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fnx\PedidoBundle\Entity\Pedido as Pedido;

/**
 * Fnx\PedidoBundle\Entity\Item
 *
 * @ORM\Table(name="pedido_item")
 * @ORM\Entity(repositoryClass="Fnx\PedidoBundle\Entity\ItemRepository")
 */
class Item
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
     * @ORM\ManyToOne(targetEntity="Pedido")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
     */
    private $pedido;

    /**
     *
     * @ORM\Column(name="nome", type="string", length=50, nullable=true)
     */
    private $nome;

    /**
     * @var string $descricao
     *
     * @ORM\Column(name="descricao", type="string", length=255)
     */
    private $descricao;

    /**
     * @var decimal $quantidade
     *
     * @ORM\Column(name="quantidade", type="decimal")
     */
    private $quantidade;

    /**
     * @var float $preco
     *
     * @ORM\Column(name="preco", type="float")
     */
    private $preco;

    public function setId($id) {
	$this->id = $id;
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
     * Set quantidade
     *
     * @param decimal $quantidade
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    /**
     * Get quantidade
     *
     * @return decimal
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set preco
     *
     * @param float $preco
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    /**
     * Get preco
     *
     * @return float
     */
    public function getPreco()
    {
        return $this->preco;
    }

    public function getTotal(){
        return $this->getPreco() * $this->getQuantidade();
    }

    public function getPedido() {
	return $this->pedido;
    }

    public function setPedido($pedido) {
	$this->pedido = $pedido;
    }

    public function getNome() {
	return $this->nome;
    }

    public function setNome($nome) {
	$this->nome = $nome;
    }

    public function getName()
    {
        return 'Item';
    }
}