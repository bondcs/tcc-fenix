<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fnx\AdminBundle\Entity\Categoria;

/**
 * Description of CategoriaFixture
 *
 * @author bondcs
 */
class CategoriaFixture implements FixtureInterface{
    
    public function load(ObjectManager $manager){
        
        $categoria = new Categoria();
        $categoria->setNome("Salário");
        $categoria->setDescricao("Pagamento de salário dos funcionários");
        $categoria->setEditavel(false);
        
        $categoria2 = new Categoria();
        $categoria2->setNome("Atividade");
        $categoria2->setDescricao("Movimentações relacionadas a atividade");
        $categoria2->setEditavel(false);
        
        $categoria3 = new Categoria();
        $categoria3->setNome("Padrão");
        $categoria3->setDescricao("Movimentações não relacionadas a uma categoria");
        $categoria3->setEditavel(false);
        
        $manager->persist($categoria);
        $manager->persist($categoria2);
        $manager->persist($categoria3);
        $manager->flush();
             
        
    }
}

?>
