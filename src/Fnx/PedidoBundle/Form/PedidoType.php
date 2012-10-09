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
		    'query_builder'=> function(\Fnx\AdminBundle\Entity\ClienteRepository $repository){
                        return $repository->createQueryBuilder('s')->orderBy('s.nome', 'ASC');}
		))
		->add('previsao','date', array('label' => 'Previsão de Entrega: '));
    }

    public function getName()
    {
        return 'fnx_pedidobundle_pedidotype';
    }
}
