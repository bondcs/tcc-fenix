<?php

namespace Fnx\FinanceiroBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Fnx\FinanceiroBundle\Form\Listener\ParcelaListener;

class MovimentacaoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('valor','text', array(
                  'label' => 'Valor:*',
                  'attr' => array(
                       'class' => 'moeda'
                  )
            ))
            ->add('valor_pago','text', array(
                  'label' => 'Valor pago:',
                  'required' => false,
                  'attr' => array(
                       'class' => 'moeda zero'
                  )
            ))->add('data_pagamento', 'date', array(
                        'label' => 'Data Pag.:*',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'format' => 'dd/MM/yyyy HH:mm:ss',
             ))
            ->add('movimentacao', 'choice', array(
                  'choices' => array('p' => 'Pagamento', 'r' => 'Recebimento')
            ))
            ->add('lembrar')
            ->add('validado')
            ->add('formaPagamento', 'entity', array(
                  'empty_value' => 'Selecione uma opção',
                  'class' => 'FnxFinanceiroBundle:FormaPagamento',
                  'label' => 'Pagamento:*'
            ))
            ->add('parcela', new ParcelaType());
            
            $em = $options['em'];
            $subscriber = new ParcelaListener($em);
            $builder->addEventSubscriber($subscriber);
    }
    
    public function getDefaultOptions(array $options) {
        return array('em' => 'lala');
    }

    public function getName()
    {
        return 'fnx_financeirobundle_movimentacaotype';
    }
}
