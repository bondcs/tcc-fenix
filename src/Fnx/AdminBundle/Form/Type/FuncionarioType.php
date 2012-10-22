<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of UserType
 *
 * @author bondcs
 */
class FuncionarioType extends AbstractType{
    
    public function buildForm(FormBuilder $builder, array $options){ 
        $dias = array();
        for ($i = 1; $i <= 30; $i++ ){
            $dias[$i] = $i;
        }
        
        $builder
            ->add('nome','text', array(
                 'label' => 'Nome:*'
            ))
            ->add('telefone', 'text', array(
                 'label' => 'Telefone:*'
            ))
            ->add('cpf', 'text', array(
               'label' => 'Cpf:',
            ))
            ->add('rg', 'text', array(
               'label' => 'Rg:',
            ))
            ->add('dependentes', 'text', array(
               'label' => 'Dependentes:',
            ))
            ->add('tipo', 'choice', array(
               'label' => 'Tipo:',
               'choices' => array(
                    'fun' => "Funcionário",
                    'free' => "Free-lancer"
               )
            ))
            ->add('categorias', 'entity', array(
               'label' => 'Tipo:',
               'class' => 'FnxAdminBundle:Categoria',
               'expanded' => true,
               'multiple' => true,
               'property' => 'nome',
             ))
            ->add("salario", new SalarioType())
            
          ;
    }

    function getName(){
        return "funcionario";
    }
    
}

?>
