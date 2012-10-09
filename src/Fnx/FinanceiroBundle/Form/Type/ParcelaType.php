<?php

namespace Fnx\FinanceiroBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Fnx\FinanceiroBundle\Form\ContaType;

class ParcelaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('dt_vencimento', 'date', array(
                        'label' => 'Vencimento:*',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'required' => true,
                        'format' => 'dd/MM/yyyy'
             ))
//            ->add('conta', new ContaType())
        ;
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Fnx\FinanceiroBundle\Entity\Parcela',
        );
    }

    public function getName()
    {
        return 'fnx_financeirobundle_parcelatype';
    }
}
