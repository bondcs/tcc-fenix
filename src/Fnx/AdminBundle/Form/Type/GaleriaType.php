<?php

namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GaleriaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nome', 'text', array(
                "label" => "Galeria:*",
                "required" => true,
             ))
//            ->add('descricao', 'textarea', array(
//                "label" => "Descrição:",
//                "required" => false,
//            ))
            ->add('files','file',array(
                "label" => "Imagens:",
                "required" => false,
                "attr" => array(
                    "accept" => "image/*",
                    "multiple" => "multiple",
                )
            ));
        ;
    }

    public function getName()
    {
        return 'fnx_adminbundle_galeriatype';
    }
}
