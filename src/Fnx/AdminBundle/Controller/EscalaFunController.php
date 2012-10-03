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
use Fnx\AdminBundle\Entity\EscalaFun;
use Fnx\AdminBundle\Entity\Funcionario;
use Fnx\AdminBundle\Form\Type\EscalaFunType;

/**
 * Description of EscalaFunController
 * 
 * @author bondcs
 * @Route("/adm/funcionario/escala")
 */
class EscalaFunController extends Controller{
    
    
    /**
     * @Route("/", name="escalaFunIndex")
     * @Template()
     */
    public function indexAction(){
        $funcionarios = $this->getDoctrine()->getRepository("FnxAdminBundle:EscalaFun")->loadEscalaFunTurno();
        return array("funcionarios" => $funcionarios);
    }
    
    /**
     * @Route("/add", name="escalaFunAdd", options={"expose" = true})
     * @Template()
     */
    public function addAction(){
        $escala = new EscalaFun();
        $form = $this->createForm(new EscalaFunType(), $escala);
        
        return array(
            "form" => $form->createView(),
        );
    }
    
     /**
     * @Route("/create", name="escalaFunCreate", options={"expose" = true})
     * @Template("FnxAdminBundle:EscalaFun:add.html.twig")
     */
    public function createAction(){
        
        $escala = new EscalaFun();
        $form = $this->createForm(new EscalaFunType(),$escala);
        $form->bindRequest($this->getRequest());
        
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
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
        );
    }
    
    /**
     * @Route("/edit/{id}", name="escalaFunEdit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $escala = $em->find("FnxAdminBundle:EscalaFun", $id);
        $form = $this->createForm(new EscalaFunType(), $escala);
        
        return array(
            "form" => $form->createView(),
            "id" => $id
        );
    }
    
     /**
     * @Route("/update/{id}", name="escalaFunUpdate", options={"expose" = true})
     * @Template("FnxAdminBundle:EscalaFun:edit.html.twig")
     */
    public function updateAction($id){
        
        $em = $this->getDoctrine()->getEntityManager();
        $escala = $em->find("FnxAdminBundle:EscalaFun", $id);
        $form = $this->createForm(new EscalaFunType(), $escala);

        $form->bindRequest($this->getRequest());
        if ($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $em->merge($escala);
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
     * @Route("/remove/{id}", name="escalaFunRemove", options={"expose" = true})
     */
    public function removeAction($id){
       $escala = $this->getDoctrine()->getRepository("FnxAdminBundle:EscalaFun")->find($id);
       if (!$escala ){
            throw $this->createNotFoundException("Escala não encontrada.");
        }
       $em = $this->getDoctrine()->getEntityManager();
       $em->remove($escala);
       $em->flush();
       
       $this->get("session")->setFlash("success","Escala excluída.");
        return $this->redirect($this->generateUrl("escalaFunIndex"));
    }

    /**
     * @Route("/ajaxEscalaFun", name="escalaFunAjax", options={"expose" = true})
     * @Template()
     */
    public function ajaxAction(){
        
        $escalasBanco = $this->getDoctrine()->getRepository("FnxAdminBundle:EscalaFun")->loadEscalaFun();
        $escalas['aaData'] = array();
       
        foreach ($escalasBanco as $key => $value) {
//            for ($i = 0; $i < (50 - strlen($value['descricao'])); $i++){
//                $value['descricao'] = $value['descricao']."a";
//            }
//            var_dump(50 - strlen($value['descricao']));
//            $value['escalaN'] = $value['funcionario']['escalaDiariaInicio']->format('H:i:s')." - ".$value['funcionario']['escalaDiariaFinal']->format('H:i:s');
            $value['escalaEx'] = $value['inicio']->format('d/m/Y H:i')." - ". $value['fim'] = $value['fim']->format('d/m/Y H:i');
            $escalas['aaData'][] = $value;
        }
       
        $response = new Response(json_encode($escalas));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    public function verificaEscala(){
        
    }

}

?>
