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
use Fnx\AdminBundle\Form\Type\UsuarioType;
/**
 * Description of ResponsavelController
 *
 * @author bondcs
 * @Route("/adm/cliente/responsavel/show/")
 */
class ResponsavelController extends Controller{
    
    /**
     * @Route("remove/{id}", name="responsavelRemove", options={"expose" = true})
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
        $response = new Response(json_encode(array()));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
    
    /**
     * @Route("add/{id}", name="responsavelAdd", options={"expose" = true})
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
               
                $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'add'
                );
            
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
     * @Route("edit/{id}", name="responsavelEdit", options={"expose" = true})
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
               
                $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'edit'
                );
            
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
     * @Route("usuario/{id}", name="usuarioManager", options={"expose" = true})
     * @Template()
     * @param type $id
     */
    public function usuarioAction($id){
        
        $responsavel = $this->getDoctrine()->getRepository("FnxAdminBundle:Responsavel")->find($id);
        if (!$responsavel){
            throw $this->createNotFoundException("Responsável não encontrado.");
        }
        
        $flag = true;
        if (!$responsavel->getUsuario()){
            $responsavel->setUsuario(new Usuario);
            $flag = false;
        }
        
        $form = $this->createForm(new UsuarioType(1,3));
        $formHandler = $this->get("fnx_admin.usuario.form.handler");
        $process = $formHandler->process($responsavel->getUsuario(), $responsavel, $form);
        
        if ($process){
            $message = $flag == true ? "edit" : "add";
            
            $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => $message
                );
            
            $response = new Response(json_encode($responseSuccess));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        
        return $this->render("FnxAdminBundle:Usuario:form.html.twig",array(
            "form" => $form->createView(),
            "father" => $responsavel,
            'responsavel' => true, 
        ));
        
    }
    
    /**
     * @Route("usuario/remove/{id}", name="usuarioRemove", options={"expose" = true})
     * @Template()
     * @param type $id
     */
    public function usuarioRemoveAction($id){
        
        $responsavel = $this->getDoctrine()->getRepository("FnxAdminBundle:Responsavel")->find($id);
        if (!$responsavel){
            throw $this->createNotFoundException("Responsável não encontrado.");
        }
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($responsavel->getUsuario());
        $em->flush();
        $this->get("session")->setFlash("success","Usuário excluído.");
        return $this->redirect($this->generateUrl("clienteShow", array("id" => $responsavel->getCliente()->getId())));


 
    }
    
    /**
     * @Route("ajaxResponsavel/{id}", name="ajaxResponsavel", options={"expose" = true})
     * @return 
     */
    public function ajaxResponsavelAction($id){
        
        $responsaveisObjetos = $this->getDoctrine()->getRepository("FnxAdminBundle:Responsavel")->loadResponsavel($id);
        
        $responsaveis['aaData'] = array();
        foreach ($responsaveisObjetos as $key => $value) {
           
              $value['cpf'] = $value['cpf'] ? $value['cpf'] : "-";
              $value['usuario'] = $value['usuario'] != null ? $value['usuario']['username'] : "-";
              $responsaveis['aaData'][] = $value;
        }
        
        $response = new Response(json_encode($responsaveis));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    
    
    
    
}

?>
