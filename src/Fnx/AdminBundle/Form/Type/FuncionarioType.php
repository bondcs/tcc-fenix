<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of UserType
 *
 * @author bondcs
 */
class FuncionarioType extends AbstractType{
    
    public function buildForm(FormBuilder $builder, array $options){
        
        $builder
            ->add('nome')
            ->add('telefone')
            ->add('tipo', 'entity', array(
               'empty_value' => 'Selecione uma opção',
               'label' => 'Tipo:*',
               'class' => 'FnxAdminBundle:TipoFun',
               'property' => 'nome',
             ))
            ->add('escalaDiariaInicio', 'time', array(
                        'label' => 'Início:*',
                        'input' => 'datetime',
                        'widget' => 'choice',   
            ))
            ->add('escalaDiariaFinal', 'time', array(
                        'label' => 'Fim:*',
                        'input' => 'datetime',
                        'widget' => 'choice', 
            ));
    }

    function getName(){
        return "funcionario";
    }
    
}

?>
