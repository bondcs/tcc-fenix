<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\FinanceiroBundle\Form\Listener;
use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Fnx\FinanceiroBundle\Entity\Parcela;
use Fnx\FinanceiroBundle\Entity\Movimentacao;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManager;

/**
 * Description of ParcelaListener
 *
 * @author bondcs
 */
class ParcelaListener implements EventSubscriberInterface{
    
    private $em;


    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public static function getSubscribedEvents() {
        return array(FormEvents::POST_BIND => 'postBindData');
    }
    
    public function postBindData(DataEvent $event){
         
         $form = $event->getForm();
         $data = $event->getData();
         $registro = $data->getParcela()->getRegistro();
         
         if (!$data->getId()){
             return;
         }
         
         $valor = substr(str_replace(",", ".", $data->getValor()),3);
         $valorPago = substr(str_replace(",", ".", $data->getValorPago()),3);
         if ($valor > $valorPago && $valorPago != 0){
             
             $diferenca = $valor - $valorPago ;
             $parcela = new Parcela();
             $parcela->setDtVencimento($data->getParcela()->getDtVencimento());
             $movimentacao = new Movimentacao();
             $movimentacao->setData(new \Datetime());
             $movimentacao->setFormaPagamento($data->getFormaPagamento());
             $movimentacao->setMovimentacao("r");
             $movimentacao->setValor($diferenca);
             $parcela->setMovimentacao($movimentacao);
             $movimentacao->setParcela($parcela);
             $registro->addParcela($parcela);
             $parcela->setRegistro($registro);
             $data->setValor($data->getValorPago());
//             $this->em->persist($registro);
//             $this->em->flush();
         }
         
    }
}

?>
