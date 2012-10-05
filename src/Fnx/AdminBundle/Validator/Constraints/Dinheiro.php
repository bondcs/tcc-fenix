<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fnx\AdminBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;

/**
 * Description of dinheiro
 *
 * @author bondcs
 */

/**
 * @Annotation
 */
class Dinheiro extends Constraint {
    
    public $message = "Formato inválido - 1000,10";
}

?>
