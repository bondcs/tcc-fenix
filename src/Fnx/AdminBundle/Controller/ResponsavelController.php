<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fnx\AdminBundle\Entity\Cliente;
use Fnx\AdminBundle\Entity\Responsavel;
use Fnx\AdminBundle\Entity\Usuario;
use Fnx\AdminBundle\Form\Type\ResponsavelType;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of ResponsavelController
 *
 * @author bondcs
 */
class ResponsavelController extends Controller{
    
    /**
     * @Route("/adm/cliente/responsavel/remove/{id}", name="responsavelRemove", options={"expose" = true})
     * @Template()
     * @param type $id
     */
    public function removeAction($id){
        
        $responsavel = $this->getDoctrine()->getRepository("FnxAdminBundle:Responsavel")
                                                            ->find($id);
        
        if (!$responsavel){throw $this->createNotFoundException("Responsável não encontrado.");}
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($responsavel);
        $em->flush();
        $this->get('session')->setFlash('success','Responsável excluído.');
        return $this->redirect($this->generateUrl("clienteShow", array('id' => $responsavel->getCliente()->getId())));

    }
    
    /**
     * @Route("/adm/cliente/responsavel/add/{id}", name="responsavelAdd", options={"expose" = true})
     * @Template()
     * @param type $id
     */
    public function addAction($id){
        
        $responsavel = new Responsavel();
        $form = $this->createForm(new ResponsavelType(), $responsavel, array('validation_groups'=>'register'));
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST'){
            $form->bindRequest($request);
            if ($form->isValid()){
               $cliente = $this->getDoctrine()->getRepository("FnxAdminBundle:Cliente")->find($id);
               $em = $this->getDoctrine()->getEntityManager();
               $cliente->getResponsaveis()->add($responsavel);
               $responsavel->setCliente($cliente);
               $em->merge($cliente);
               $em->flush();
               
               $this->get('session')->setFlash("success","Responsável registrado.");
               
               $responseSuccess = array('success' => $this->generateUrl("clienteShow", array('id' => $id)));
               $response = new Response(json_encode($responseSuccess));
               $response->headers->set('Content-Type', 'application/json');
               return $response;
               
            }
            
        }
        
        return $this->render("FnxAdminBundle:Responsavel:form.html.twig",array(
            'form' => $form->createView(),
            'responsavel' => $responsavel,
            'clienteId' => $id,
        ));

    }
    
    /**
     * @Route("/adm/cliente/responsavel/edit/{id}", name="responsavelEdit", options={"expose" = true})
     * @Template()
     * @param type $id
     */
    public function editAction($id){
        
        $responsavel = $this->getDoctrine()->getRepository("FnxAdminBundle:Responsavel")->find($id);
        $form = $this->createForm(new ResponsavelType(), $responsavel, array('validation_groups'=>'register'));
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST'){
            $form->bindRequest($request);
            if ($form->isValid()){
               $em = $this->getDoctrine()->getEntityManager();
               $em->merge($responsavel);
               $em->flush();
               
               $this->get('session')->setFlash("success","Responsável alterado.");
               
               $responseSuccess = array('success' => $this->generateUrl("clienteShow", array('id' => $responsavel->getCliente()->getId())));
               $response = new Response(json_encode($responseSuccess));
               $response->headers->set('Content-Type', 'application/json');
               return $response;
               
            }
            
        }
        
        return $this->render("FnxAdminBundle:Responsavel:form.html.twig",array(
            'form' => $form->createView(),
            'responsavel' => $responsavel,
            'clienteId' => $id,
        ));

    }
    
    /**
     * @Route("/adm/cliente/responsavel/usuario/{id}", name="usuarioManager", options={"expose" = true})
     * @Template()
     * @param type $id
     */
    public function usuarioAction($id){
        
        $responsavel = $this->getDoctrine()->getRepository("FnxAdminBundle:Responsavel")->find($id);
        if (!$responsavel){
            throw $this->createNotFoundException("Responsável não encontrado.");
        }
        if (!$responsavel->getUsuario()){
            $responsavel->setUsuario(new Usuario);
        }
        
        $form = $this->get("fnx_admin.usuario.form");
        $formHandler = $this->get("fnx_admin.usuario.form.handler");
        $process = $formHandler->process($responsavel->getUsuario(), $responsavel);
        
        if ($process){
            $this->get("session")->setFlash("success","Usuário registrado.");
            $url = $this->generateUrl("clienteShow", array("id" => $responsavel->getCliente()->getId()));
            $response = new Response(json_encode(array("success" => $url)));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        
        return $this->render("FnxAdminBundle:Usuario:form.html.twig",array(
            "form" => $form->createView(),
            "responsavel" => $responsavel,
        ));
        
    }
    
    
    
    
    
}

?>
