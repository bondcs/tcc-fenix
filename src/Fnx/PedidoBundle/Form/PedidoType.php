<?php

namespace Fnx\PedidoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PedidoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('cliente', 'entity', array(
		    'class'=>'FnxAdminBundle:Cliente',
		    'property'=>'nome',
		    'query_builder' => function(EntityRepository $er) {
			return $er->createQueryBuilder('u')
			->orderBy('u.nome', 'ASC');
		    },
		    'expanded'  => false,
		    'multiple'  => false
		))
		->add('previsao','date', new \Date())
		->getForm();
    }

    public function getName()
    {
        return 'fnx_pedidobundle_pedidotype';
    }
}
