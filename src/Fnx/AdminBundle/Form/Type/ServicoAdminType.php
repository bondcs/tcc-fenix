<?php

namespace Fnx\AdminBundle\Type\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ServicoAdminType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('descricao','text',array(
                  'label' => 'Descrição:*'
            ))
            ->add('valor','text',array(
                  'label' => 'Valor:*'
            ))
            ->add('fornecedor')
        ;
    }

    public function getName()
    {
        return 'fnx_adminbundle_servicoadmintype';
    }
}
