<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Listener;
use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;

/**
 * Description of EscalaListener
 *
 * @author bondcs
 */
class EscalaListener implements EventSubscriberInterface{
    
    private $form;
    private $em;


    public function __construct(FormFactoryInterface $form, EntityManager $em) {
        $this->form = $form;
        $this->em = $em;
    }
    
    public static function getSubscribedEvents() {
        return array(FormEvents::POST_BIND => 'postBindData');
    }
    
    public function postBindData(DataEvent $event){
         
         $resp = $this->em->getRepository("FnxAdminBundle:Escala");
         $form = $event->getForm();
         $data = $event->getData();
         
         $funcionarios = $form->get("funcionarios")->getData()->toArray();
         if ($funcionarios == array()){
             $form->get('funcionarios')->addError(new FormError("Selecione um funcionário"));
             return;
         }
             
         if ($data->getDtInicio() == null || $data->getDtFim() == null){
             return;
         }
         
         if ($data->getDtInicio() > $data->getDtFim()){
             $form->addError(new FormError("Data final menor que a data inicial"));
             return;
         }
         
         foreach ($funcionarios as $value) {
             $flag = true;
             $escalas = $resp->verificaEscala($value->getId(), $data->getDtInicio(), $data->getDtFim());
             if ($escalas != null){
                  foreach ($escalas as $escala){
                          if ($value->getEscalas()->contains($escala) && $escala->getId() == $data->getId()){
                              $flag = false;
                          }
                  }
                  if ($flag){
                    $form->get('funcionarios')->addError(new FormError($value->getNome() . " não é válido nesta escala."));
                  }
             }
             
         }
    }
}

?>
