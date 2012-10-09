<?php

namespace Fnx\FinanceiroBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\NotBlank;
use Fnx\AdminBundle\Validator\Constraints\Dinheiro;
use Symfony\Component\Validator\Constraints\Collection;

class RegistroType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('descricao','text', array(
                  'label' => 'Descrição:',
            ))
            ->add('conta', 'entity', array(
                  'label' => 'Conta:*',
                  'class' => 'FnxFinanceiroBundle:Conta',
                  'empty_value' => 'Selecione uma conta'
            ))
            ->add('valor', 'text', array(
                  'label' => 'Valor:*',
                  'attr' => array('class' => 'moeda'),
            ))
            ->add('formaPagamento', 'entity', array(
                  'empty_value' => 'Selecione uma opção',
                  'label' => 'Pagamento:*',
                  'class' => 'FnxFinanceiroBundle:FormaPagamento',
            ))
            ->add('parcela', 'text', array(
                  'label' => 'Nº Parcelas:*',
                  'data' => 1,
            ))
        ;
    }
    
    public function getDefaultOptions(array $options)
    {
        $collectionConstraint = new Collection(array(
            'conta' => new NotBlank(),
            'descricao' => new NotBlank(),
            'valor' => new Dinheiro(),
            'formaPagamento' => new NotBlank(),
            'parcela' => new NotBlank(),
        ));
        
        return array('validation_constraint' => $collectionConstraint);
    }

    public function getName()
    {
        return 'fnx_financeirobundle_registrotype';
    }
}
