<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;
/**
 * Description of ResponsavelRepository
 *
 * @author bondcs
 */
class ResponsavelRepository extends EntityRepository {
    
    public function loadResponsavel($id){   
        return $this->getEntityManager()
                ->createQuery('SELECT r
                               FROM FnxAdminBundle:Responsavel r WHERE r.cliente = :id')
                ->setParameter("id", $id)
                ->getResult();
    }

}

?>
