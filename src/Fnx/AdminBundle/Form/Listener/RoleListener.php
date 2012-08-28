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

/**
 * Description of RoleListener
 *
 * @author bondcs
 */
class RoleListener implements EventSubscriberInterface{
    
    private $form;
    
    public function __construct(FormFactoryInterface $form) {
        $this->form = $form;
    }
    
    public static function getSubscribedEvents() {
        return array(FormEvents::POST_BIND => 'postBindData');
    }
    
    public function postBindData(DataEvent $event){
        
         $form = $event->getForm();
         $data = $event->getData();

         if(!$data->getUserRoles()->isEmpty()) return;
         $msg = 'Selecione uma permissão';
         $form->get('userRoles')->addError(new FormError($msg));
    }
    
    
    
    
    
}

?>
