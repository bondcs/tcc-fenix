<?php

namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PropriedadeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nome','text',array(
                'label' => 'Nome:*'
            ))
            ->add('quantidade','text',array(
                'label' => 'Quantidade:*'
            ))
            ->add('descricao','text',array(
                'label' => 'Descrição:'
            ))
        ;
    }

    public function getName()
    {
        return 'fnx_adminbundle_propriedadetype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => "Fnx\AdminBundle\Entity\Propriedade",
        );
    }
}
