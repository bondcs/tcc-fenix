<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
/**
 * Description of intervaloType
 *
 * @author bondcs
 */
class intervaloType extends AbstractType{
    
    function getName() {
        return "intervalo";
    }
    
    function buildForm(FormBuilder $builder, array $options) {
        
        $builder
            ->add("normal", "time", array(
                "input" => "timestamp",
                "widget" => "choice",
            ))
            ->add("noturno", "time", array(
                "input" => "timestamp",
                "widget" => "choice",
            ));
    }
}

?>
