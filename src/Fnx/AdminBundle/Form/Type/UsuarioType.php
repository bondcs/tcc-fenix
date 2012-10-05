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
use Doctrine\ORM\EntityRepository;

/**
 * Description of UsuarioType
 *
 * @author bondcs
 */
class UsuarioType extends AbstractType{
    
    private $p1;
    private $p2;


    function __construct($p1 = 0, $p2 = 0) {
       $this->p1 = $p1;
       $this->p2 = $p2;
    }   


    function buildForm(FormBuilder $builder, array $options) {
            $p1 = $this->p1;
            $p2 = $this->p2;
        
            $builder
                ->add('username','text',array(
                        'label' => 'Login:*'
                ))
                ->add('password', 'repeated', array (
                        'type'            => 'password',
                        'first_name'      => "Senha:",
                        'second_name'     => "Confirmar Senha:",
                        'invalid_message' => "As senhas não combinam!" 
                ))
                ->add('userRoles', 'entity', array(
                        'multiple' => true,
                        'expanded' => true,
                        'class' => 'FnxAdminBundle:Role',
                        'query_builder' => function(EntityRepository $er) use ($p1, $p2) {
                           return $er->createQueryBuilder('r')
                           ->where('r.id <> ?1
                                   AND r.id <> ?2')
                           ->setParameters(array(1 => $p1, 2 => $p2));
                        },
                ));
             
             $subscriber = new RoleListener($builder->getFormFactory());
             $builder->addEventSubscriber($subscriber);
    }
    
    

    function getName() {
        return "fnx_admin_usuario";
    }
    
}

?>
