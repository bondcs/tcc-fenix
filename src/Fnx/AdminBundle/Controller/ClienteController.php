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
use Fnx\AdminBundle\Form\ClienteType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of ClienteController
 *
 * @author bondcs
 */
class ClienteController extends Controller{
    
    /**
     * @Route("adm/cliente", name="clienteHome")
     * @Template()
     * @return 
     */
    public function indexAction(){
        $clientes = $this->getDoctrine()->getRepository("FnxAdminBundle:Cliente")
                                                                              ->findAll();
        
        return array(
            "clientes" => $clientes, 
        );
    }
    
    /**
     * @Route("adm/cliente/add", name="clienteAdd")
     * @Template("")
     * @return 
     */
    public function addClienteAction(){
        $cliente = new Cliente();
        $form = $this->createForm(new ClienteType($cliente), $cliente);
        $request = $this->getRequest();
        if ($request->getMethod() == "POST"){
            $cidades = $this->getDoctrine()->getRepository("FnxAdminBundle:Cidade")->loadCidadeObject($_POST['cliente']['estado']);
            $form = $this->createForm(new ClienteType($cliente, $cidades), $cliente);
            $form->bindRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($cliente);
                $em->flush();
                $session = $this->get("session")->setFlash("success","Cadastro concluído.");
                return $this->redirect($this->generateUrl("clienteHome"));
            }else{
                $session = $this->get("session")->setFlash("error","O formulário não foi validado.");
            }
        }
        
        return $this->render("FnxAdminBundle:Cliente:formCli.html.twig" ,array(
            'form' => $form->createView(),
            'cliente' => $cliente,
        ));
    }
    
    /**
     * @Route("adm/usuario/edit/{id}", name="clienteEdit", options={"expose" = true})
     * @Template()
     * @return 
     */
    public function editClienteAction($id){
        
        $cliente = $this->getDoctrine()->getRepository("FnxAdminBundle:Cliente")->find($id);
        if (!$cliente){
            throw $this->createNotFoundException("Funcionário não encontrado.");
        }
        $cidades = $this->getDoctrine()->getRepository("FnxAdminBundle:Cidade")->loadCidadeObject($cliente->getCidade()->getEstado()->getId());
        $form = $this->createForm(new ClienteType($cliente, $cidades), $cliente);
        $request = $this->getRequest();
        if ($request->getMethod() == "POST"){
            $cidades = $this->getDoctrine()->getRepository("FnxAdminBundle:Cidade")->loadCidadeObject($_POST['cliente']['estado']);
            $form = $this->createForm(new ClienteType($cliente, $cidades), $cliente);
            $form->bindRequest($request);

            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($cliente);
                $em->flush();
                $session = $this->get("session")->setFlash("success","Cadastro alterado.");
                return $this->redirect($this->generateUrl("clienteHome"));
            }else{
                $session = $this->get("session")->setFlash("error","O formulário não foi validado.");
            }
        }
        
        return $this->render("FnxAdminBundle:Cliente:formCli.html.twig" ,array(
            'form' => $form->createView(),
            'cliente' => $cliente,
        ));
    }
    
    /**
     * @Route("adm/cliente/ajaxCidade", name="ajaxCidade", options={"expose" = true})
     * @return 
     */
    public function ajaxCidadeAction(){
        
        $request = $this->getRequest();
        $id = $request->get("estadoId");
        $cidades = $this->getDoctrine()->getRepository("FnxAdminBundle:Cidade")->loadCidade($id);
        $response = new Response(json_encode($cidades));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @Route("adm/cliente/remove/{id}", name="clienteRemove", options={"expose" = true})
     * @return 
     */
    public function removeClienteAction($id){
       
       $cliente = $this->getDoctrine()->getRepository("FnxAdminBundle:Cliente")->find($id);
       if (!$cliente){
            throw $this->createNotFoundException("Cliente não encontrado.");
       }
       $em = $this->getDoctrine()->getEntityManager();
       $em->remove($cliente);
       $em->flush();
       $this->get('session')->setFlash('success', 'Cliente excluído.');  
       return $this->redirect($this->generateUrl("clienteHome"));
    }
    
    /**
     * @Route("adm/cliente/show/{id}", name="clienteShow", options={"expose" = true})
     * @Template()
     */
    public function showProfileAction($id){
        $cliente = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository("FnxAdminBundle:Cliente")
                    ->find($id);
        
        if (!$cliente){
            throw $this->createNotFoundException("Cliente não encontrado.");
        }
        
        
        return array("cliente" => $cliente);
    }
}

?>
