<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of UsuarioType
 *
 * @author bondcs
 */
class UsuarioType extends AbstractType{
    
    function buildForm(FormBuilder $builder, array $options) {
            $builder
                ->add('username')
                ->add('password', 'repeated', array (
                        'type'            => 'password',
                        'first_name'      => "Password",
                        'second_name'     => "Re-enter Password",
                        'invalid_message' => "The passwords don't match!" 
                ))
                ->add('userRoles', 'entity', array(
                        'multiple' => true,
                        'expanded' => true,
                        'property' => 'role',
                        'class' => 'FnxAdminBundle:Role',
                ));
    }


    function getName() {
        return "user";
    }
}

?>
