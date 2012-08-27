<?php

namespace Fnx\PedidoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PedidoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Cliente', 'text', array(
                    'label'  => 'Cliente'  ))
            ->add('previsao', 'date', array(
                    'widget' => 'single_text',
                    'label'  => 'Previsão de entrega'))
            ->add('itens','choice')
        ;
    }

    public function getName()
    {
        return 'fnx_pedidobundle_pedidotype';
    }
}
