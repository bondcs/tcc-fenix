<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\FinanceiroBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormError;
use Fnx\FinanceiroBundle\Entity\Registro;
use Fnx\FinanceiroBundle\Entity\Parcela;
use Fnx\FinanceiroBundle\Entity\Movimentacao;

/**
 * Description of RegistroFormHandler
 *
 * @author bondcs
 */
class RegistroFormHandler {
    
    protected $em;
    protected $form;
    protected $request;
    
    public function __construct(Form $form, Request $request, EntityManager $em) {
        $this->em = $em;
        $this->form = $form;
        $this->request = $request;
    }
    
    public function process(Registro $registro){

        if ($this->request->getMethod() == "POST"){
            $this->form->bindRequest($this->request);
            if ($this->form->isValid()){
                $this->onSuccess($registro);
                return true;
            }
        }
        return false;
    }
    
    public function onSuccess(Registro $registro){
        
        $data = $this->form->getData();
        $registro->setConta($data['conta']);
//        $registro->setDescricao($data['descricao']);
        
        for ($i = 0; $i < $data['parcela']; $i++){
             $parcela = new Parcela();
             $parcela->setDtVencimento(new \DateTime('+'.$i.' month'));
             $parcela->setRegistro($registro);
             
             $movimentacao = new Movimentacao();
             $movimentacao->setFormaPagamento($data['formaPagamento']);
             $movimentacao->setParcela($parcela);
             $movimentacao->setMovimentacao('r');
             $movimentacao->setValor($registro->calculaParcela($data['parcela'], $data['valor']));
             $registro->addParcela($parcela);
             $parcela->setMovimentacao($movimentacao);
        }
        
        $conta = $data['conta'];
        $conta->addRegistro($registro);
        //var_dump($registro->getParcelas()->get(0)->getMovimentacao()->getValor());die();
        $this->em->persist($registro);
        $this->em->flush();
    }
    
    
}

?>
