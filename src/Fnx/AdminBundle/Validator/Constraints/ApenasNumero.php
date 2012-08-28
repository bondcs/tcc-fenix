<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
/**
 * Description of ApenasNumero
 *
 * @author bondcs
 */

/**
 * @Annotation
 */
class ApenasNumero extends Constraint{
    
    public $message = 'Esta campo aceita somente números.'; 
}

?>
