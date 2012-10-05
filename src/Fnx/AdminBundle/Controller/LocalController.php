<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fnx\AdminBundle\Entity\Endereco;
use Fnx\AdminBundle\Entity\Local;
use Fnx\AdminBundle\Form\Type\LocalType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * Description of LocalController
 *
 * @author bondcs
 * @Route("adm/atividade/show/local")
 */
class LocalController extends Controller{
    
    /**
     * @Route("/new/{id}", name="localAdd", options={"expose" = true})
     * @Template()
     * @return 
     */
    function newAction($id){
        
        $local = new Local();
        $form = $this->createForm(new LocalType(), $local);
        
        return array("form" => $form->createView(),
                     "id" => $id);
        
    }
    
    /**
     * @Route("/create/{id}", name="localCreate")
     * @Template("FnxAdminBundle:Local:new.html.twig")
     */
    function createAction($id){
        
        $local = new Local();
        $form = $this->createForm(new LocalType(), $local);
        $request = $this->getRequest();
        
        $form->bindRequest($request);
        if ($form->isValid()){
            
            $em = $this->getDoctrine()->getEntityManager();
            $atividade = $em->find("FnxAdminBundle:Atividade", $id);
            $local->setAtividade($atividade);
            $em->persist($local);
            $em->flush();
            
            $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'add'
                );
            $response = new Response(json_encode($responseSuccess));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return array('form' => $form->createView(),
                     'id' => $id);
        
    }
    
    /**
     * @Route("/edit/{id}", name="localEdit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id){
        
        $local = $this->getDoctrine()->getEntityManager()->find("FnxAdminBundle:Local", $id);
        if (!$local){
            throw $this->createNotFoundException("Local não encontrada.");
        }
        
        $form = $this->createForm(new LocalType(), $local);
        return array(
            "form" => $form->createView(),
            "id" => $id,
        );
    }
    
    /**
     * @Route("/update/{id}", name="localUpdate", options={"expose" = true})
     * @Method({"POST"})
     * @Template("FnxAdminBundle:Local:edit.html.twig")
     */
    public function updateAction($id){
        $local = $this->getDoctrine()->getEntityManager()->find("FnxAdminBundle:Local", $id);
        if (!$local){
            throw $this->createNotFoundException("Local não encontrado.");
        }
        $form = $this->createForm(new LocalType(), $local);
        $request = $this->getRequest();
        $form->bindRequest($request);
        
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $em->merge($local);
            $em->flush();
            
            $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'edit'
            );
            
            $response = new Response(json_encode($responseSuccess));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        
        return array(
            "form" => $form->createView(),
            "id" => $id
        );
    }
    
    /**
     * @Route("/delete/{id}", name="localDelete", options={"expose" = true})
     * @Method({"POST"})
     */
    function deleteAction($id){
        
        $em = $this->getDoctrine()->getEntityManager();
        $local = $em->find("FnxAdminBundle:Local", $id);
        if (!$local){
            throw $this->createNotFoundException("Local não encontrado.");
        }
        
        $em->remove($local);
        $em->flush();
        
        $response = new Response(json_encode(array()));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    /**
     * @Route("/ajaxLocal/{id}", name="ajaxLocal", options={"expose" = true})
     * @return 
     */
    public function ajaxLocalAction($id){
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $atividade = $em->find("FnxAdminBundle:Atividade", $id);
        $locaisBanco = $em
                    ->createQuery("SELECT l,c FROM FnxAdminBundle:Local l
                                   JOIN l.cidade c
                                   WHERE l.atividade = :atividade")
                    ->setParameter('atividade', $atividade)
                    ->getArrayResult();
        
        $locais['aaData'] = array();
        foreach ($locaisBanco as $local){
            $local['custoNumber'] = $local['custo'];
            $local['custo'] = number_format($local['custo'],2,',','.');
            $locais['aaData'][] = $local;
        }
        
        $response = new Response(json_encode($locais));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}

?>
