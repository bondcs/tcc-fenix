<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fnx\FinanceiroBundle\Entity\Instancia;
use Fnx\FinanceiroBundle\Entity\Conta;

/**
 * Description of ContaFixture
 *
 * @author bondcs
 */
class ContaFixture extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(ObjectManager $manager){
        
        $instancia = new Instancia;
        $instancia->setNome("Empresa");
        $instancia->setDescricao("Contas relacionadas a empresa");
        $manager->persist($instancia);
        
        $conta = new Conta;
        $conta->setNome("Caixa");
        $conta->setDescricao("Movimentações de caixa");
        $conta->setValor(0);
        $conta->setInstancia($instancia);
        $manager->persist($conta);
        
        $manager->flush();
        
        $this->addReference("conta-caixa", $conta);
 
    }
    
    public function getOrder() {
        return 1;
    }
}

?>
