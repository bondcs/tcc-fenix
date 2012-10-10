<?php

namespace Fnx\PedidoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('descricao')
            ->add('quantidade')
            ->add('preco');
    }

    public function getName()
    {
        return 'fnx_pedidobundle_itemtype';
    }
}

?>