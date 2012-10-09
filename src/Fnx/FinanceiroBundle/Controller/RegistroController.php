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
use Fnx\FinanceiroBundle\Entity\Registro;
use Fnx\FinanceiroBundle\Entity\Movimentacao;
use Fnx\FinanceiroBundle\Form\Type\RegistroType;

/**
 * Description of RegistroController
 *
 * @author bondcs
 */
class RegistroController extends Controller{
    
    /**
     * @Route("/new/{id}", name="registroNew")
     * @Template()
     */
    function newAction($id){
        
        $registro = new Registro();
        $form = $this->createForm(new RegistroType(), $registro);
        
        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
    
    /**
     * @Route("/create/{id}", name="registroCreate")
     * @Template("FnxAdminBundle:registro:new.html.twig")
     */
    function createAction($id){
        
        $registro = new Registro();
        $form = $this->createForm(new RegistroType(), $registro);
        $request = $this->getRequest();
        
        $form->bindRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $atividade = $em->find("FnxAdminBundle:Atividade", $id);
            $atividade->setRegistro($movimentacao->getParcela()->getRegistro());
            $em->persist($movimentacao);
            $em->flush();
            
            $this->get('session')->setFlash("success","Registro efetuado.");
            $response = new Response(json_encode(array("url" => $this->generateUrl("atividadeShow", array('id' => $id)),
                                                       "notifity" => "add")));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
    
    /**
     * @Route("/edit/{id}", name="RegistroEdit")
     * @Template()
     */
    function editAction($id){
        $atividade = $this->getDoctrine()->getRepository("FnxAdminBundle:Atividade")->find($id);
        $form = $this->createForm(new RegistroType());
        
        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
}

?>

