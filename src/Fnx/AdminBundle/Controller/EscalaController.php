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
use Fnx\AdminBundle\Entity\Escala;
use Fnx\AdminBundle\Form\Type\EscalaType;
/**
 * Description of Escala
 *
 * @author bondcs
 * @Route("/adm/atividade/show/escala")
 */
class EscalaController extends Controller{
    
    /**
     * 
     */
    public function indexAction(){
       $escalas = $this->getDoctrine()->getRernpository("FnxAdminBundle:Escala")->findAll();
       return array("escalas" => $escalas);
    }
    
    /**
     * @Route("/add/{id}", name="escalaAdd", options={"expose" = true})
     * @Template()
     */
    public function addAction($id){
        $escala = new Escala();
        $atividade = $this->getDoctrine()->getEntityManager()->find("FnxAdminBundle:Atividade", $id);
        $form = $this->get("fnx_admin.escala.form");
        
        return array(
            "form" => $form->createView(),
            "atividade" => $atividade
        );
    }
    
        /**
     * @Route("/create/{id}", name="escalaCreate", options={"expose" = true})
     * @Template("FnxAdminBundle:Escala:add.html.twig")
     */
    public function createAction($id){
        $escala = new Escala();
        $em = $this->getDoctrine()->getEntityManager();
        $atividade = $em->find("FnxAdminBundle:Atividade", $id);
        $form = $this->get("fnx_admin.escala.form");
        $form->setData($escala);
        $form->bindRequest($this->getRequest());
//        $funcionarios = $form->get("funcionarios")->getData();
//        $funcionarios[1]->addError(new \Symfony\Component\Form\FormError("lala"));    
        if ($form->isValid()){
            $escala->setAtividade($atividade);
            $em->persist($escala);
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
            "atividade" => $atividade
        );
    }
    
    /**
     * @Route("/edit/{id}", name="escalaEdit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id){
        
        $escala = $this->getDoctrine()->getEntityManager()->find("FnxAdminBundle:Escala", $id);
        if (!$escala){
            throw $this->createNotFoundException("Escala não encontrada.");
        }
        $form = $this->get("fnx_admin.escala.form");
        $form->setData($escala);
        
        return array(
            "form" => $form->createView(),
            "escala" => $escala,
        );
    }
    
    /**
     * @Route("/update/{id}", name="escalaUpdate", options={"expose" = true})
     * @Method({"POST"})
     * @Template("FnxAdminBundle:Escala:edit.html.twig")
     */
    public function updateAction($id){
        $escala = $this->getDoctrine()->getEntityManager()->find("FnxAdminBundle:Escala", $id);
        if (!$escala){
            throw $this->createNotFoundException("Escala não encontrada.");
        }
        $form = $this->get("fnx_admin.escala.form");
        $form->setData($escala);
        $form->bindRequest($this->getRequest());
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $em->merge($escala);
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
            "escala" => $escala,
        );
    }
    
    /**
     * @Route("/delete/{id}", name="escalaDelete", options={"expose" = true})
     * @Method({"POST"})
     */
    function deleteAction($id){
        
        $em = $this->getDoctrine()->getEntityManager();
        $escala = $em->find("FnxAdminBundle:Escala", $id);
        if (!$escala){
            throw $this->createNotFoundException("Escala não encontrada.");
        }
        
        $em->remove($escala);
        $em->flush();
        
        $response = new Response(json_encode(array()));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }


    /**
     * @Route("/ajaxEscala/{id}", name="ajaxEscala", options={"expose" = true})
     * @return 
     */
    public function ajaxEscalaAction($id){
        
        $escalasBanco = $this->getDoctrine()->getRepository("FnxAdminBundle:Escala")->loadEscala($id);
        $escalas['aaData'] = array();
        foreach ($escalasBanco as $key => $value) {
            $value['dtInicio'] = date("d/m/Y H:i:s", strtotime($value['dtInicio']));
            $value['dtFim'] = date("d/m/Y H:i:s", strtotime($value['dtFim']));
            $array[0] = $value['dtInicio'];
            $array[1] = $value['dtFim'];
            $array[2] = $value['id'];
            $escalas['aaData'][] = $array;
        }
        
        $response = new Response(json_encode($escalas));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}

?>
