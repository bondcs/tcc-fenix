<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * Description of ChangePasswordType
 *
 * @author bondcs
 */
class ChangePasswordType extends AbstractType{
    
    public function buildForm(FormBuilder $builder, array $options) {
        
        $builder->add('password', 'repeated', array (
                        'type'            => 'password',
                        'first_name'      => "Senha",
                        'second_name'     => "Repita Senha",
                        'invalid_message' => "As senhas não combinam."
                     ));
    }
    
    public function getDefaultOptions(array $options){
        $collectionConstraint = new Collection(array(
            'password' => array(
                            new NotBlank(),
                            new MinLength(4),
                          )
        ));

        return array('validation_constraint' => $collectionConstraint);
    }
    
    function getName() {
       return 'changePassword';
    }
}

?>
