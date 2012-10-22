<?php

namespace Fnx\FinanceiroBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

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
                        'data' => new \Datetime('-1 days'),
             ))
            ->add('inicioTime', 'date', array(
                        'label' => 'Início:*',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'required' => true,
                        'format' => 'dd/MM/yyyy HH:mm:ss',
                        'data' => new \Datetime('-1 days'),
                ))
            ->add('fim', 'date', array(
                        'label' => 'Fim:',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'format' => 'dd/MM/yyyy',
                        'data' => new \Datetime(),
                        
             ))
            ->add('fimTime', 'date', array(
                        'label' => 'Início:*',
                        'input' => 'datetime',
                        'widget' => 'single_text',
                        'required' => true,
                        'format' => 'dd/MM/yyyy HH:mm:ss',
                        'data' => new \Datetime('-1 days')
                ))
            ->add('tipo', 'choice', array(
                        'label' => 'Tipo:',
                        'choices' => $options['choices']
             ))
            ->add('tipo_data', 'choice', array(
                        'label' => 'Tipo de data:',
                        'expanded' => true,
                        'multiple' => false,
                        'choices' => array('r' => 'Registrado', 'p' => 'Pagamento', 'v' => 'Vencimento'),
                        'attr' => array('class' => 'tipoData'),
                        'data' => 'r'
             ))
           ->add('conta', 'entity', array(
                        'label' => 'Conta:',
                        'class' => 'FnxFinanceiroBundle:Conta',
                        'property' => 'nome',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->orderBy('c.nome', 'ASC');
                        },
             ))
           ->add('categoria', 'entity', array(
                        'empty_value' => "Todos os serviços",
                        'label' => 'Serviço:',
                        'class' => 'FnxAdminBundle:Categoria',
                        'property' => 'nome',
                        'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->orderBy('c.nome', 'ASC');
                        },
             ))
            ->add('status', 'choice', array(
                        'label' => 'Status:',
                        'choices' => array("t" => "Todos",
                                           "a" => "Ativo",
                                           "c" => "Concluído")
             ))
        ;
    }

    public function getName()
    {
        return 'fnx_financeirobundle_filtertype';
    }
    
    public function getDefaultOptions(array $options) {
        return array('choices' => array());
    }
}
