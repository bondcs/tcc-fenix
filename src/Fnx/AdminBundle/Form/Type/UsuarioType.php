<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormError;
use Fnx\AdminBundle\Form\Listener\RoleListener;

/**
 * Description of UsuarioType
 *
 * @author bondcs
 */
class UsuarioType extends AbstractType{
    
    function buildForm(FormBuilder $builder, array $options) {
            $builder
                ->add('username','text',array(
                        'label' => 'Login:*'
                ))
                ->add('password', 'repeated', array (
                        'type'            => 'password',
                        'first_name'      => "Senha:",
                        'second_name'     => "Re-enter Senha:",
                        'invalid_message' => "As senhas não combinam!" 
                ))
                ->add('userRoles', 'entity', array(
                        'multiple' => true,
                        'expanded' => true,
                        'class' => 'FnxAdminBundle:Role',
                ));
             
             $subscriber = new RoleListener($builder->getFormFactory());
             $builder->addEventSubscriber($subscriber);
    }
    
    

    function getName() {
        return "fnx_admin_usuario";
    }
    
}

?>
