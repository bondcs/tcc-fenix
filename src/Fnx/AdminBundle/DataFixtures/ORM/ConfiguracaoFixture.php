<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fnx\AdminBundle\Entity\Configuracao;

/**
 * Description of ConfiguracaoFixture
 *
 * @author bondcs
 */
class ConfiguracaoFixture extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(ObjectManager $manager){
        
        $config = new Configuracao;
        $config->setValorDependente(20);
        $config->setContaSalario($this->getReference('conta-caixa'));
        $config->setFormaPagamentoSalario($this->getReference("forma-dinheiro"));
        $manager->persist($config);
        
        $manager->flush();
       
    }
    
    public function getOrder() {
        return 2;
    }
}

?>
