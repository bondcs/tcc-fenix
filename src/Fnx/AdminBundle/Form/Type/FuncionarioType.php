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
            ->add('telefone');
    }

    function getName(){
        return "funcionario";
    }
    
}

?>
