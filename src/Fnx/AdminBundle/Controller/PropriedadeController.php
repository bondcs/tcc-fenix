<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Controller;
use Fnx\AdminBundle\Entity\Propriedade;
use Fnx\AdminBundle\Form\Type\PropriedadeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Description of PropriedadeController
 *
 * @author bondcs
 * @Route("adm/atividade/show")
 */
class PropriedadeController extends Controller {
    
 
    /**
     * @Route("/add/{id}", name="propriedadeAdd", options={"expose" = true})
     * @Template()
     */
    public function addAction($id){
        $propriedade = new Propriedade();
        $form = $this->createForm(new PropriedadeType, $propriedade);
        
        return array(
            "form" => $form->createView(),
            "id" => $id
        );
    }
    
        /**
     * @Route("/create/{id}", name="propriedadeCreate", options={"expose" = true})
     * @Template("FnxAdminBundle:Propriedade:add.html.twig")
     */
    public function createAction($id){
        $propriedade = new Propriedade();
        $form = $this->createForm(new PropriedadeType, $propriedade);
        $form->bindRequest($this->getRequest());
        
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $atividade = $em->find("FnxAdminBundle:Atividade", $id);
            $propriedade->setAtividade($atividade);
            $em->persist($propriedade);
            $em->flush();
            $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'add'
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
     * @Route("/edit/{id}", name="propriedadeEdit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id){
        
        $propriedade = $this->getDoctrine()->getEntityManager()->find("FnxAdminBundle:Propriedade", $id);
        if (!$propriedade){
            throw $this->createNotFoundException("Propriedade não encontrada.");
        }
        $form = $this->createForm(new PropriedadeType, $propriedade);
        
        return array(
            "form" => $form->createView(),
            "id" => $id,
        );
    }
    
    /**
     * @Route("/update/{id}", name="propriedadeUpdate", options={"expose" = true})
     * @Method({"POST"})
     * @Template("FnxAdminBundle:Propriedade:edit.html.twig")
     */
    public function updateAction($id){
        $propriedade = $this->getDoctrine()->getEntityManager()->find("FnxAdminBundle:Propriedade", $id);
        if (!$propriedade){
            throw $this->createNotFoundException("Propriedade não encontrada.");
        }
        $form = $this->createForm(new PropriedadeType, $propriedade);
        $form->bindRequest($this->getRequest());
        
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $em->merge($propriedade);
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
            "id" => $id,
        );
    }
    
    /**
     * @Route("/delete/{id}", name="propriedadeRemove", options={"expose" = true})
     * @Method({"POST"})
     */
    function deleteAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $propriedade = $em->find("FnxAdminBundle:Propriedade", $id);
        if (!$propriedade){
            throw $this->createNotFoundException("Propriedade não encontrada.");
        }
        
        $em->remove($propriedade);
        $em->flush();
        
        $response = new Response(json_encode(array()));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    /**
     * @Route("/check/{id}", name="propriedadeCheck", options={"expose" = true})
     * @Method({"POST"})
     */
    function checkAction($id){
        
        $em = $this->getDoctrine()->getEntityManager();
        $propriedade = $em->find("FnxAdminBundle:Propriedade", $id);
        if (!$propriedade){
            throw $this->createNotFoundException("Propriedade não encontrada.");
        }
        
        $valor =  $propriedade->getChecado() ? false : true;
        $propriedade->setChecado($valor);
        
        $em->merge($propriedade);
        $em->flush();

        $response = new Response(json_encode(array()));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }


    /**
     * @Route("/ajaxPropriedade/{id}", name="ajaxPropriedade", options={"expose" = true})
     * @return 
     */
    public function ajaxPropriedadeAction($id){
        
        $propriedadesBanco = $this->getDoctrine()->getRepository("FnxAdminBundle:Propriedade")->loadPropriedade($id);
        $propriedades['aaData'] = array();
        
        foreach ($propriedadesBanco as $key => $value) {
            //var_dump($value['checado']);die();
            $propriedades['aaData'][] = $value;
        }
      
        $response = new Response(json_encode($propriedades));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}

?>
