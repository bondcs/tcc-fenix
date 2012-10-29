<?php

namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ConfiguracaoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('valorDependente', 'text', array(
                  'label' => 'Dependente:*'
            ))
            ->add('contaSalario', 'entity', array(
                  'property' => 'nome',
                  'class' => 'FnxFinanceiroBundle:Conta',
                  'label' => 'Conta:*'
            ))
            ->add('formaPagamentoSalario', 'entity', array(
                  'property' => 'nome',
                  'class' => 'FnxFinanceiroBundle:FormaPagamento',
                  'label' => 'Pagamento:*'
            ))
        ;
    }

    public function getName()
    {
        return 'fnx_adminbundle_configuracaotype';
    }
}
