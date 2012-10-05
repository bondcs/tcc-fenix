<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fnx\AdminBundle\Form\Type\EnderecoType;
use Fnx\AdminBundle\Entity\Endereco;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Description of EnderecoController
 *
 * @author bondcs
 * @Route("/adm/atividade/endereco")
 */
class EnderecoController extends Controller{
    
    /**
     * @Route("/new/{id}", name="EnderecoNew")
     * @Template()
     */
    function newAction($id){
        
        $endereco = new Endereco();
        $form = $this->createForm(new EnderecoType(), $endereco);
        
        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
    
    /**
     * @Route("/create/{id}", name="enderecoCreate")
     * @Template("FnxAdminBundle:Endereco:new.html.twig")
     */
    function createAction($id){
        
        $endereco = new Endereco();
        $cidades = $this->getDoctrine()->getRepository("FnxAdminBundle:Cidade")->loadCidadeObject($_POST['endereco']['estado']);
        $form = $this->createForm(new EnderecoType($cidades), $endereco);
        $request = $this->getRequest();

        $form->bindRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $atividade = $em->find("FnxAdminBundle:Atividade", $id);
            $endereco->setAtividade($atividade);
            $em->persist($endereco);
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
    
    /**
     * @Route("/edit/{id}", name="EnderecoEdit")
     * @Template()
     */
    function editAction($id){
        
        $atividade = $this->getDoctrine()->getRepository("FnxAdminBundle:Atividade")->find($id);
        $cidades = $this->getDoctrine()->getRepository("FnxAdminBundle:Cidade")->loadCidadeObject($atividade->getEnderecos()->get(0)->getCidade()->getEstado()->getId());
        $form = $this->createForm(new EnderecoType($cidades,$atividade->getEnderecos()->get(0)), $atividade->getEnderecos()->get(0));
        
        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
    
    /**
     * @Route("/update/{id}", name="enderecoUpdate")
     * @Method({"POST"})
     * @Template("FnxAdminBundle:Endereco:new.html.twig")
     */
    function updateAction($id){
        
        $atividade = $this->getDoctrine()->getRepository("FnxAdminBundle:Atividade")->find($id);
        $cidades = $this->getDoctrine()->getRepository("FnxAdminBundle:Cidade")->loadCidadeObject($_POST['endereco']['estado']);
        $endereco = $atividade->getEnderecos()->get(0);
        $form = $this->createForm(new EnderecoType($cidades, $endereco), $endereco);
        $request = $this->getRequest();

        $form->bindRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $atividade = $em->find("FnxAdminBundle:Atividade", $id);
            $em->persist($atividade);
            $em->flush();
            
            $this->get('session')->setFlash("success","Endereço alterado.");
            $response = new Response(json_encode(array("url" => $this->generateUrl("atividadeShow", array('id' => $id)),
                                                       "notifity" => "edit")));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
    
}

?>
