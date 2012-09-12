<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Fnx\AdminBundle\Form\Listener\CategoriaListener;

/**
 * Description of AtividadeType
 *
 * @author bondcs
 */
class AtividadeType extends AbstractType{
    
    function buildForm(FormBuilder $builder, array $options) {
        
        $builder
            ->add("nome","text", array(
                "label" => "Nome:*"
            ))
            ->add("descricao","textarea", array(
                "label" => "Descrição:*"
            ))
            ->add("servico", "entity", array(
                "empty_value" => "Escolha uma opção",
                "property" => "nome",
                "class" => "FnxAdminBundle:Servico",
                "label" => "Serviço:*"
            ))
//            ->add('categorias', 'entity', array(
//                'property' => 'nome',
//                'multiple' => true,
//                'expanded' => true,
//                'class' => 'FnxAdminBundle:Categoria',
//            ))
            ->add('cliente','text', array(
                'property_path' => false,
                'label' => 'Cliente:*'
            ));
         
//        $subscriber = new CategoriaListener($builder->getFormFactory());
//        $builder->addEventSubscriber($subscriber);
    }

    function getName() {
        return "fnx_admin_atividade";
    }
}

?>
