<?php

namespace Fnx\FinanceiroBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nome','text', array(
                  'label' => 'Nome:*'
            ))
            ->add('descricao', 'textarea', array(
                  'label' => 'Descrição:',
                  'required' => false
            ))
            ->add('valor', 'text', array(
                  'label' => 'Valor:',
                  'required' => false
            ))
            ->add('instancia','entity', array(
                  'label' => 'Instância:*',
                  'class' => 'FnxFinanceiroBundle:Instancia',
                  "empty_value" => "Escolha uma opção",
            ))
        ;
    }

    public function getName()
    {
        return 'fnx_financeirobundle_contatype';
    }
}
