<?php

namespace Fnx\FinanceiroBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\NotBlank;
use Fnx\AdminBundle\Validator\Constraints\Dinheiro;
use Symfony\Component\Validator\Constraints\Collection;

class RegistroMovType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('conta', 'entity', array(
                  'label' => 'Conta:*',
                  'class' => 'FnxFinanceiroBundle:Conta',
                 //'empty_value' => 'Selecione uma conta',
            ))
            ->add('descricao', 'text', array(
                  'label' => 'Decricão:*'
            ))
        ;
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Fnx\FinanceiroBundle\Entity\Registro',
        );
    }
    
    public function getName()
    {
        return 'fnx_financeirobundle_registromovtype';
    }
}
