<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\FinanceiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Fnx\FinanceiroBundle\Entity\Movimentacao;
use Fnx\FinanceiroBundle\Form\MovimentacaoType;
/**
 * Description of MovimentacaoController
 *
 * @author bondcs
 * @Route("/financeiro")
 */
class MovimentacaoController extends Controller{
    
    /**
     * @Route("/", name="financeiroShow")
     * @Template()
     *
     */
    function indexAction(){
        
        return array();
    }

    /**
     * @Route("/new/{id}", name="movimentacaoNew")
     * @Template()
     */
    function newAction($id){
        
        $endereco = new Endereco();
        $form = $this->createForm(new EnderecoType(), $endereco);
        
        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
    
    /**
     * @Route("/create/{id}", name="movimentacaoCreate")
     * @Template("FnxAdminBundle:movimentacao:new.html.twig")
     */
    function createAction($id){
        
        $movimentacao = new Movimentacao();
        $form = $this->createForm(new MovimentacaoType(), $movimentacao);
        $request = $this->getRequest();

        $form->bindRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $atividade = $em->find("FnxAdminBundle:Atividade", $id);
            $atividade->setRegistro($movimentacao->getParcela()->getRegistro());
            $em->persist($movimentacao);
            $em->flush();
            
            $this->get('session')->setFlash("success","Endereço cadastrado.");
            $response = new Response(json_encode(array("url" => $this->generateUrl("atividadeShow", array('id' => $id)),
                                                       "notifity" => "add")));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
}

?>
