<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fnx\AdminBundle\Entity\Cliente;
use Fnx\AdminBundle\Entity\Usuario;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fnx\AdminBundle\Entity\Responsavel
 *
 * @ORM\Table(name="responsavel")
 * @ORM\Entity
 */
class Responsavel
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
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=45)
     * 
     * @Assert\NotBlank()
     * @Assert\MinLength(5)
     */
    private $nome;

    /**
     * @var string $telefone
     *
     * @ORM\Column(name="telefone", type="string", length=10)
     * @Assert\NotBlank()
     */
    private $telefone;
    
    /**
     * @var objeto $cliente
     * 
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="responsaveis")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;
    
    /**
     * @var objeto $usuario
     * 
     * @ORM\OneToOne(targetEntity="Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $usuario;

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
     * Set nome
     *
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set cliente
     *
     * @param Fnx\AdminBundle\Entity\Cliente $cliente
     */
    public function setCliente(\Fnx\AdminBundle\Entity\Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Get cliente
     *
     * @return Fnx\AdminBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set usuario
     *
     * @param Fnx\AdminBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\Fnx\AdminBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return Fnx\AdminBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}