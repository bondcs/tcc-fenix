<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Fnx\AdminBundle\Entity\Funcionario
 *
 * @ORM\Table(name="funcionario")
 * @ORM\Entity(repositoryClass="Fnx\AdminBundle\Entity\FuncionarioRepository")
 */
class Funcionario
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
     * @ORM\Column(name="nome", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nome;
    
    /**
     * @var object Usuario
     * 
     * @ORM\OneToOne(targetEntity="Fnx\AdminBundle\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", onDelete="SET NULL")   
     */
    private $usuario;

    /**
     * @var string $telefone
     *
     * @ORM\Column(name="telefone", type="string", length=10)
     * @Assert\NotBlank()
     */
    private $telefone;

    
    public function __construct() {
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