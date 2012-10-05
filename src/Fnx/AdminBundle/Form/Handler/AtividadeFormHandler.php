<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Handler;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Fnx\AdminBundle\Entity\Atividade;
use Fnx\AdminBundle\Entity\Contrato;
use Symfony\Component\Form\FormError;
/**
 * Description of AtividadeFormHandler
 *
 * @author bondcs
 */
class AtividadeFormHandler {
    
    private $form;
    private $em;
    private $request;
    
    public function __construct(Form $form, Request $request, EntityManager $em) {
        
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
    }
    
    public function process(Atividade $atividade){
        
        $this->form->setData($atividade);
        
        $cliente = $this->em->getRepository("FnxAdminBundle:Cliente")
                                            ->findOneBy(array("nome" => $this->form->get("cliente")->getData()));
        
        if ($cliente == null){
            $this->form->get("nome")->addError(new FormError("Cliente inválido."));
        }else{
            $contrato = new Contrato();
            $atividade->setContrato($contrato->setCliente($cliente));
        }
         
        if ($this->request->getMethod() == "POST"){
            $this->form->bindRequest($this->request);
            if($this->form->isValid()){
               $this->onSuccess($atividade);
               return true;
            }
        }
        return false;
        
    }
    
    public function onSuccess(Atividade $atividade){
        
        $atividade->getId() ? $this->em->merge($atividade) : $this->em->persist($atividade);  
        $this->em->flush();
    }
    
}

?>
