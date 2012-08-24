<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
/**
 * Description of ResponsavelType
 *
 * @author bondcs
 */
class ResponsavelType extends AbstractType{
    
    public function getName() {
        return 'responsavel';
    }
    
    function buildForm(FormBuilder $builder, array $options) {
            
         $builder->add('nome','text', array(
                'label' => 'Nome:*'
                 ))
                 ->add('telefone', 'text', array(
                     'max_length' => 10,
                     'label' => 'Telefone:*'
                 ))
                 ->add('cpf', 'text', array(
                     'max_length' => 11,
                     'label' => 'Cpf:',
                     'required' => false
                 ));
        
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => "Fnx\AdminBundle\Entity\Responsavel",
        );
    }
    
}

?>
