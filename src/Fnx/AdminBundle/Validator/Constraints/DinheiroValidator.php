<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Description of DinheiroValidator
 *
 * @author bondcs
 */
class DinheiroValidator extends ConstraintValidator{
    
    public function isValid($value, Constraint $constraint) {
        
        if (!preg_match('/^(R\$ ?)?[0-9]+([.,][0-9]{2})$/', $value, $matches)) {
            $this->setMessage($constraint->message, array('%string%' => $value));
            return false;
        }

        return true;
    }
}

?>
