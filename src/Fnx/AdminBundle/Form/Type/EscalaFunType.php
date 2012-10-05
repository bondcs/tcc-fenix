<?php

namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class EscalaFunType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('inicio', 'date', array(
                        'label' => 'Início:*',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'required' => true,
                        'format' => 'dd/MM/yyyy HH:mm:ss'
                ))
            ->add('fim', 'date', array(
                        'label' => 'Fim:*',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'required' => true,
                        'format' => 'dd/MM/yyyy HH:mm:ss'
                ))
            ->add('descricao','text',array(
                        'label' => 'Descrição:*',
                        'required' => false,
                        'max_length' => 60
                 ))
            ->add('funcionario','entity',array(
                        'empty_value' => 'Selecione uma opcão',
                        'label' => 'Funcionário:*',
                        'class' => 'FnxAdminBundle:Funcionario',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('f')
                           ->join('f.tipo', 't')
                           ->where('t.id <> ?1')
                           ->setParameter(1,2);
                        },
                        'property' => 'nome'
                ));
    }

    public function getName()
    {
        return 'fnx_adminbundle_escalafuntype';
    }
}
