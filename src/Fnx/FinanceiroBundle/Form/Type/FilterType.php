<?php

namespace Fnx\FinanceiroBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('inicio', 'date', array(
                        'label' => 'Início:',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'format' => 'dd/MM/yyyy',
                        'data' => new \Datetime('-30 days'),
             ))
            ->add('fim', 'date', array(
                        'label' => 'Fim:',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'format' => 'dd/MM/yyyy',
                        'data' => new \Datetime(),
                        
             ))
            ->add('tipo', 'choice', array(
                        'label' => 'Tipo:',
                        'choices' => array(
//                            'todas' => 'Todas',
                            'finalizadas' => 'Finalizadas',
//                            'ativas' => 'Ativas',
                        )
             ))
        ;
    }

    public function getName()
    {
        return 'fnx_financeirobundle_filtertype';
    }
}
