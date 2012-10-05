<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fnx\AdminBundle\Entity\Contrato;
use Fnx\AdminBundle\Entity\Servico;
use Fnx\AdminBundle\Entity\Galeria;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fnx\AdminBundle\Entity\Atividade
 *
 * @ORM\Table(name="atividade")
 * @ORM\Entity(repositoryClass="Fnx\AdminBundle\Entity\AtividadeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Atividade
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
     */
    private $nome;

    /**
     * @var string $descricao
     *
     * @ORM\Column(name="descricao", type="string", length=255)
     * @Assert\NotBlank()
     */
    //private $descricao;

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
     * @ORM\Column(name="arquivado",type="boolean", nullable=false)
     * @var boolean $arquivado
     */
    private $arquivado;
    
    /**
     * @var object $contrato
     * 
     * @ORM\ManyToOne(targetEntity="Contrato", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(name="contrato_id", referencedColumnName="id")
     */
    private $contrato;
    
    
    /**
     * @var object $servico
     * 
     * @ORM\ManyToOne(targetEntity="Servico", fetch="LAZY")
     * @ORM\JoinColumn(name="servico_id", referencedColumnName="id")
     * 
     * @Assert\NotBlank()
     */
    private $servico;
    
    /**
     * @ORM\ManyToMany(targetEntity="Categoria")
     * @ORM\JoinTable(name="atividade_categoria",
     *     joinColumns={@ORM\JoinColumn(name="atividade_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="categoria_id", referencedColumnName="id")}
     * )
     * )
     * @var ArrayCollection $categorias
     */
    private $categorias;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Endereco", mappedBy="atividade", cascade={"all"})
     * @var ArrayCollection $enderecos
     */
    private $enderecos;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Escala", mappedBy="atividade", cascade={"all"})
     * @var ArrayCollection $escalas
     */
    private $escalas;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Local", mappedBy="atividade", cascade={"all"})
     * @var ArrayCollection $locais
     */
    private $locais;
    
    /**
     * 
     * @ORM\OneToOne(targetEntity="Galeria", mappedBy="atividade", cascade={"all"})
     * @var ArrayCollection $galerias
     */
    private $galeria;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Propriedade", mappedBy="atividade", cascade={"all"})
     * @var ArrayCollection $propriedades
     */
    private $propriedades;
    
   
    public function __construct() {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->arquivado = false;
        $this->categorias = new ArrayCollection();
        $this->escalas = new ArrayCollection();
        $this->enderecos = new ArrayCollection();
        $this->locais = new ArrayCollection();
        $this->propriedades = new ArrayCollection();
        
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
    public function getDescricao($length = null)
    {
        if ($length != null && $length > 0){
            return substr($this->descricao, 0, $length);
        }
        return $this->descricao;
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
    
    /**
     * Set arquivado
     *
     * @param boolean $arquivado
     */
    public function setArquivado($arquivado)
    {
        $this->arquivado = $arquivado;
    }

    /**
     * Get arquivado
     *
     * @return boolean 
     */
    public function getArquivado()
    {
        return $this->arquivado;
    }
    
    /**
     * @ORM\PreRemove
     */
    public function setRemovedValue(){
        $this->arquivado = true;
        
    }
    
    /**
     * Set contrato
     *
     * @param Fnx\AdminBundle\Entity\Contrato $contrato
     */
    public function setContrato(\Fnx\AdminBundle\Entity\Contrato $contrato)
    {
        $this->contrato = $contrato;
    }

    /**
     * Get contrato
     *
     * @return Fnx\AdminBundle\Entity\Contrato 
     */
    public function getContrato()
    {
        return $this->contrato;
    }

    /**
     * Add categorias
     *
     * @param Fnx\AdminBundle\Entity\Categoria $categorias
     */
//    public function addCategoria(\Fnx\AdminBundle\Entity\Categoria $categorias)
//    {
//        $this->categorias[] = $categorias;
//    }

    /**
     * Get categorias
     *
     * @return Doctrine\Common\Collections\Collection 
     */
//    public function getCategorias()
//    {
//        return $this->categorias;
//    }

    /**
     * Set servico
     *
     * @param Fnx\AdminBundle\Entity\Servico $servico
     */
    public function setServico(\Fnx\AdminBundle\Entity\Servico $servico)
    {
        $this->servico = $servico;
    }

    /**
     * Get servico
     *
     * @return Fnx\AdminBundle\Entity\Servico 
     */
    public function getServico()
    {
        return $this->servico;
    }

    /**
     * Add categorias
     *
     * @param Fnx\AdminBundle\Entity\Categoria $categorias
     */
    public function addCategoria(\Fnx\AdminBundle\Entity\Categoria $categorias)
    {
        $this->categorias[] = $categorias;
    }

    /**
     * Get categorias
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Add escalas
     *
     * @param Fnx\AdminBundle\Entity\Escala $escalas
     */
    public function addEscala(\Fnx\AdminBundle\Entity\Escala $escalas)
    {
        $this->escalas[] = $escalas;
    }

    /**
     * Get escalas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEscalas()
    {
        return $this->escalas;
    }

    /**
     * Add enderecos
     *
     * @param Fnx\AdminBundle\Entity\Endereco $enderecos
     */
    public function addEndereco(\Fnx\AdminBundle\Entity\Endereco $enderecos)
    {
        $this->enderecos[] = $enderecos;
    }

    /**
     * Get enderecos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEnderecos()
    {
        return $this->enderecos;
    }

    /**
     * Get galeria
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGaleria()
    {
        return $this->galeria;
    }

    /**
     * Set galeria
     *
     * @param Fnx\AdminBundle\Entity\Galeria $galeria
     */
    public function setGaleria(\Fnx\AdminBundle\Entity\Galeria $galeria)
    {
        $this->galeria = $galeria;
    }

    /**
     * Add locais
     *
     * @param Fnx\AdminBundle\Entity\Local $locais
     */
    public function addLocal(\Fnx\AdminBundle\Entity\Local $locais)
    {
        $this->locais[] = $locais;
    }

    /**
     * Get locais
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLocais()
    {
        return $this->locais;
    }

    /**
     * Add propriedades
     *
     * @param Fnx\AdminBundle\Entity\Propriedade $propriedades
     */
    public function addPropriedade(\Fnx\AdminBundle\Entity\Propriedade $propriedades)
    {
        $this->propriedades[] = $propriedades;
    }

    /**
     * Get propriedades
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPropriedades()
    {
        return $this->propriedades;
    }
}