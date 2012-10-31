<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Fnx\FinanceiroBundle\Entity\FormaPagamento;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Description of FormaPagamentoFixture
 *
 * @author bondcs
 */
class FormaPagamentoFixture extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(ObjectManager $manager){
        
        $forma = new FormaPagamento;
        $forma->setNome("Dinheiro");
        
        $forma2 = new FormaPagamento;
        $forma2->setNome("Cartão de Crédito");
        
        $forma3 = new FormaPagamento;
        $forma3->setNome("Cheque");
        
        $forma4 = new FormaPagamento;
        $forma4->setNome("Depósito");
        
        $forma5 = new FormaPagamento;
        $forma5->setNome("Transferência");
        
        $manager->persist($forma);
        $manager->persist($forma2);
        $manager->persist($forma3);
        $manager->persist($forma4);
        $manager->persist($forma5);

        $manager->flush();
        
        $this->addReference("forma-dinheiro", $forma);
      
    }
    
    public function getOrder() {
        return 1;
    }
}

?>
