<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PropriedadeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PropriedadeRepository extends EntityRepository
{
    public function loadPropriedade($id){
        
        return $this->getEntityManager()
                ->createQuery('SELECT p
                               FROM FnxAdminBundle:Propriedade p
                               WHERE p.atividade = :id
                               ORDER BY p.id')
                ->setParameter("id", $id)
                ->getArrayResult();
    }
}