<?php

namespace Fnx\FinanceiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fnx\FinanceiroBundle\Entity\Conta;
use Fnx\FinanceiroBundle\Form\Type\ContaType;
use Fnx\FinanceiroBundle\Form\Type\FilterType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Conta controller.
 *
 * @Route("/financeiro/conta")
 */
class ContaController extends Controller
{
    /**
     * Lists all Conta entities.
     *
     * @Route("/", name="financeiro_conta")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('FnxFinanceiroBundle:Conta')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Conta entity.
     *
     * @Route("/{id}/show", name="financeiro_conta_show", options={"expose" = true})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxFinanceiroBundle:Conta')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conta entity.');
        }
        
        $formFilter = $this->createForm(new FilterType(), null, array(
                    'choices' => array('finalizadas' => 'Finalizadas' 
                     )
        ));
        
        return array(
            'entity' => $entity,
            'formFilter' => $formFilter->createView());
    }

    /**
     * Displays a form to create a new Conta entity.
     *
     * @Route("/new", name="financeiro_conta_new", options={"expose" = true})
     * @Template()
     */
    public function newAction()
    {
        $entity = new Conta();
        $form   = $this->createForm(new ContaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Conta entity.
     *
     * @Route("/create", name="financeiro_conta_create")
     * @Method("post")
     * @Template("FnxFinanceiroBundle:Conta:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Conta();
        $request = $this->getRequest();
        $form    = $this->createForm(new ContaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
           $em = $this->getDoctrine()->getEntityManager();
           $em->persist($entity);
           $em->flush();

           $this->get("session")->setFlash("success","Cadastro concluído.");
           return $this->redirect($this->generateUrl("financeiro_conta"));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Conta entity.
     *
     * @Route("/{id}/edit", name="financeiro_conta_edit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxFinanceiroBundle:Conta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conta entity.');
        }

        $editForm = $this->createForm(new ContaType(), $entity);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Conta entity.
     *
     * @Route("/{id}/update", name="financeiro_conta_update")
     * @Method("post")
     * @Template("FnxFinanceiroBundle:Conta:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxFinanceiroBundle:Conta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conta entity.');
        }

        $editForm   = $this->createForm(new ContaType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get("session")->setFlash("success","Cadastro alterado.");
            return $this->redirect($this->generateUrl("financeiro_conta"));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Conta entity.
     *
     * @Route("/{id}/delete", name="financeiro_conta_delete", options={"expose" = true})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('FnxFinanceiroBundle:Conta')->find($id);

        if (!$entity) {
             throw $this->createNotFoundException('Unable to find Conta entity.');
        }

        $em->remove($entity);
        $em->flush();
            
        $this->get("session")->setFlash("success","Cadastro excluído.");
        return $this->redirect($this->generateUrl("financeiro_conta"));
    }
    
    /**
     *
     * @Route("/ajaxTransacao/{inicio}//{fim}/{tipo}/{conta}", name="ajaxTransacao", options={"expose" = true},requirements={"inicio" = ".+", "fim" = ".+"})
     */
    public function ajaxTransacao($inicio, $fim, $tipo, $conta){
        $movimentacoesBanco = $this->getDoctrine()->getRepository("FnxFinanceiroBundle:Movimentacao")->getMovimentacoes($inicio, $fim, $tipo, $conta);
    
        $movimentacoes['aaData'] = array();
        
        foreach ($movimentacoesBanco as $key => $value) {
            $value['data']= $value['data']->format('d/m/Y H:i:s');
            $value['valorNumber'] = $value['valor'];
            $value['valor'] = number_format($value['valor'],2,',','.');
            $value['tipo'] = $value['movimentacao'] == 'r' ? "Recebimento" : "Pagamento";
            $value['descricao'] = $value['parcela']['registro']['descricao'];
            $value['data_pagamento'] = $value['data_pagamento']->format('d/m/Y H:i:s');
            
            $movimentacoes['aaData'][] = $value;
        }
        
        return $this->responseAjax($movimentacoes);
    }
    
    public function responseAjax($json){
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
