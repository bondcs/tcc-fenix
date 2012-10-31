<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Fnx\AdminBundle\Entity\Configuracao;
use Fnx\AdminBundle\Form\Type\ConfiguracaoType;

/**
 * Description of ConfiguracaoController
 *
 * @author bondcs
 * @Route("adm/configuracao/")
 */
class ConfiguracaoController extends Controller{
    
    /**
     * Displays a form to edit an existing Configuração entity.
     *
     * @Route("edit", name="configEdit", options={"expose" = true})
     * @Template()
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxAdminBundle:Configuracao')->findAll();
        $entity = $entity[0];
        
        if (!$entity) {
            throw $this->createNotFoundException('Configuração não encontrado.');
        }
        $editForm = $this->createForm(new ConfiguracaoType(), $entity);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Configuração entity.
     *
     * @Route("update", name="configUpdate")
     * @Template("FnxAdminBundle:Configuracao:edit.html.twig")
     */
    public function updateAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

       $entity = $em->getRepository('FnxAdminBundle:Configuracao')->findAll();
       $entity = $entity[0];
       
        if (!$entity) {
            throw $this->createNotFoundException('Configuração não encontrado.');
        }

        $editForm   = $this->createForm(new ConfiguracaoType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
           $em->persist($entity);
           $em->flush();
          
           $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'edit'
                );

           return $this->responseAjax($responseSuccess);
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }
    
    public function responseAjax($json){
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}

?>
