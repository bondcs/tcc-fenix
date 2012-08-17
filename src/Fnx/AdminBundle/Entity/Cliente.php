<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fnx\AdminBundle\Entity\Cidade;
use Doctrine\Common\Collections\ArrayCollection;
use Fnx\AdminBundle\Entity\Responsavel;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fnx\AdminBundle\Entity\Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="Fnx\AdminBundle\Entity\ClienteRepository")
 */
class Cliente
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
     * @var string $cnpj
     *
     * @ORM\Column(name="cnpj", type="string", length=14)
     * @Assert\NotBlank()
     * @Assert\MinLength(14)
     */
    private $cnpj;

    /**
     * @var string $cep
     *
     * @ORM\Column(name="cep", type="string", length=10, nullable=true)
     * @Assert\MinLength(8)
     */
    private $cep;
       
    /**
     * @var objeto $cidade
     * 
     * @ORM\ManyToOne(targetEntity="Cidade")
     * @ORM\JoinColumn(name="cidade_id", referencedColumnName="id") 
     */
    private $cidade;
    
    /**
     * @var string $bairro
     *
     * @ORM\Column(name="bairro", type="string", length=45, nullable=true)
     */
    private $bairro;

    /**
     * @var string $rua
     *
     * @ORM\Column(name="rua", type="string", length=80, nullable=true)
     */
    private $rua;

    /**
     * @var string $numero
     *
     * @ORM\Column(name="numero", type="string", length=10, nullable=true)
     */
    private $numero;
    
    /**
     * @var ArrayCollection $responsaveis
     * 
     * @ORM\OneToMany(targetEntity="Responsavel", mappedBy="cliente")
     * 
     */
    private $responsaveis;
    
    
    public function __construct() {
        $responsaveis = new ArrayCollection();
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
     * Set cnpj
     *
     * @param string $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * Get cnpj
     *
     * @return string 
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set cep
     *
     * @param string $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * Get cep
     *
     * @return string 
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * Get bairro
     *
     * @return string 
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set rua
     *
     * @param string $rua
     */
    public function setRua($rua)
    {
        $this->rua = $rua;
    }

    /**
     * Get rua
     *
     * @return string 
     */
    public function getRua()
    {
        return $this->rua;
    }

    /**
     * Set numero
     *
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set cidade
     *
     * @param Fnx\AdminBundle\Entity\Cidade $cidade
     */
    public function setCidade(\Fnx\AdminBundle\Entity\Cidade $cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * Get cidade
     *
     * @return Fnx\AdminBundle\Entity\Cidade 
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Add responsaveis
     *
     * @param Fnx\AdminBundle\Entity\Responsavel $responsaveis
     */
    public function addResponsavel(\Fnx\AdminBundle\Entity\Responsavel $responsaveis)
    {
        $this->responsaveis[] = $responsaveis;
    }

    /**
     * Get responsaveis
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getResponsaveis()
    {
        return $this->responsaveis;
    }
}