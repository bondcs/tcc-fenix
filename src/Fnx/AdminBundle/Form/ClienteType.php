<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Fnx\AdminBundle\Entity\Cliente;
/**
 * Description of ClienteType
 *
 * @author bondcs
 */
class ClienteType extends AbstractType{
    
    protected $cliente;
    protected $cidades;


    public function __construct(Cliente $cliente, $cidades = array()) {
        
        $this->cliente = $cliente;
        $this->cidades = $cidades;
    }   

    public function buildForm(FormBuilder $builder, array $options) {

        $estado = $this->cliente->getCidade() ? $this->cliente->getCidade()->getEstado() : null;

        $builder
            ->add('nome')
            ->add('telefone')
            ->add('cnpj')
            ->add('cep')
            ->add('estado', 'entity', array(
                'empty_value' => 'Selecione uma opcão',
                'property' => 'nome',
                'class' => 'FnxAdminBundle:Estado',
                'property_path' => false,
                'data' => $estado
            ))
            ->add('cidade', 'entity', array(
                'empty_value' => 'Selecione um estado antes',
                'class' => 'FnxAdminBundle:Cidade',
                'property' => 'nome',
                'choices' => $this->cidades

            ))
            ->add('bairro')
            ->add('rua')
            ->add('numero');
        
    }
    
    
    
    
    public function getName() {
        return "cliente";
    }
    //put your code here
}

?>
