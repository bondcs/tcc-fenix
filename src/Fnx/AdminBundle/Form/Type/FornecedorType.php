<?php

namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FornecedorType extends AbstractType
{
    private $fornecedor;
    private $cidades;

    public function __construct($fornecedor, $cidades = array()) {
        $this->fornecedor = $fornecedor;
        $this->cidades = $cidades;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {

        $estado = $this->fornecedor->getCidade() ? $this->fornecedor->getCidade()->getEstado() : null;
        
        $builder
            ->add('nome', 'text', array(
                  'label' => 'Nome:*'
            ))
            ->add('telefone', 'text', array(
                  'label' => 'Telefone:*'
            ))
            ->add('cep', 'text', array(
                  'label' => 'Cep:'
            ))
            ->add('bairro', 'text', array(
                  'label' => 'Bairro:'
            ))
            ->add('rua', 'text', array(
                  'label' => 'Rua:'
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
                'label' => 'Estado:'
            ))
            ->add('cidade', 'entity', array(
                'empty_value' => 'Selecione um estado antes',
                'class' => 'FnxAdminBundle:Cidade',
                'property' => 'nome',
                'choices' => $this->cidades,
                'label' => 'Cidade:'

            ))
        ;
    }

    public function getName()
    {
        return 'fnx_adminbundle_fornecedortype';
    }
}
