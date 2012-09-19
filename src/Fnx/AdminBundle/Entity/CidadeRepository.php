<?php

namespace Fnx\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CidadeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CidadeRepository extends EntityRepository
{
    
    public function loadCidade($id){
        
        return $this->getEntityManager()
                ->createQuery('SELECT c.id, c.nome FROM FnxAdminBundle:Cidade c WHERE c.estado = :idestado')
                ->setParameter("idestado", $id)
                ->getResult();
    }
    
    public function loadCidadeObject($id){
        
        return $this->getEntityManager()
                ->createQuery('SELECT c FROM FnxAdminBundle:Cidade c WHERE c.estado = :idestado')
                ->setParameter("idestado", $id)
                ->getResult();
    }
    
}

?>
