<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
/**
 * Description of EnderecoType
 *
 * @author bondcs
 */
class EnderecoType extends AbstractType{
    
    private $cidades;
    private $endereco;
    
    function getName() {
       return 'endereco';
    }
    
    function __construct($cidades = array(), $endereco = null) {
        $this->cidades = $cidades;
        $this->endereco = $endereco;
    }


    function buildForm(FormBuilder $builder, array $options) {
        
        if ($this->endereco != null){
            $estado = $this->endereco->getCidade() ? $this->endereco->getCidade()->getEstado() : null;
        }else{
            $estado = null;
        }
        
        $builder
            ->add('bairro','text', array(
                'label' => 'Bairro:*'
            ))
            ->add('rua', 'text', array(
                'label' => 'Rua:*'
            ))
            ->add('numero', 'text', array(
                'label' => 'Número:'
            ))
            ->add('complemento', 'text', array(
                'label' => 'Complemento:'
            ))
            ->add('estado', 'entity', array(
                'empty_value' => 'Selecione uma opcão',
                'property' => 'nome',
                'class' => 'FnxAdminBundle:Estado',
                'property_path' => false,
                'data' => $estado,
                'label' => 'Estado:*'
            ))
            ->add('cidade', 'entity', array(
                'empty_value' => 'Selecione um estado antes',
                'class' => 'FnxAdminBundle:Cidade',
                'property' => 'nome',
                'choices' => $this->cidades,
                'label' => 'Cidade:*'
            ));
                
    }
}

?>
