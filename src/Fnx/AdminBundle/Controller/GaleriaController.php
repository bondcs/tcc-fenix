<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fnx\AdminBundle\Entity\Galeria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fnx\AdminBundle\Form\Type\GaleriaType;
use Symfony\Component\HttpFoundation\Response;
use Fnx\AdminBundle\Entity\Imagem;

/**
 * Description of GaleriaController
 *
 * @author bondcs
 */
class GaleriaController extends Controller {
    
    
    /**
     * @Route("adm/galeria/add/{id}", name="galeriaAdd")
     * @Template()
     */
    public function addAction($id){
        
        $galeria = $this->getDoctrine()->getRepository("FnxAdminBundle:Galeria")->findOneBy(array("atividade" => $id));
        if ($galeria == null){
            $galeria = new Galeria();
        }
        
        $form = $this->createForm(new GaleriaType(), $galeria);
        $formView = $form->createView();
        $formView->getChild('files')->set('full_name', 'fnx_adminbundle_galeriatype[files][]');
        
        return array("form" => $formView,
                     "id" => $id);
    }

    /**
     * @Route("adm/galeria/create/{id}", name="galeriaCreate")
     * @Template("FnxAdminBundle:Galeria:add.html.twig")
     */
    public function createAction($id){
        
        $galeria = $this->getDoctrine()->getRepository("FnxAdminBundle:Galeria")->findOneBy(array("atividade" => $id));
        if ($galeria == null){
            $galeria = new Galeria();
        }
        
        $form = $this->createForm(new GaleriaType(), $galeria);
        $formView = $form->createView();
        $formView->getChild('files')->set('full_name', 'fnx_adminbundle_galeriatype[files][]');
        $request = $this->getRequest();
        $form->bindRequest($request);
        if ($form->isValid()){
            
            $files = $galeria->getFiles();
            if ($files[0] != null){
                foreach ($files as $imagem){
                    $galeria->addImagem(new Imagem());
                }
                $galeria->upload(); 
            }
            
            $em = $this->getDoctrine()->getEntityManager();
            $atividade = $em->find("FnxAdminBundle:Atividade",$id);
            $galeria->setAtividade($atividade);
            $em->persist($galeria);
            $em->flush();
            
            $this->get("session")->setFlash("success", "Galeria atualizada");
            $responseSuccess = array(
                  'url' => $this->generateUrl("atividadeShow", array("id" => $id)));
            
            $response = new Response(json_encode($responseSuccess));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
            
            //return $this->redirect($this->generateUrl("atividadeShow", array("id" => $id)));
            
        }
        
        return array("form" => $formView,
                      "id" => $id);
    }
    
    /**
     * 
     * @Route("adm/galeria/show/{id}", name="galeriaShow")
     * @Template()
     * @throws type
     */
    public function showAction($id){
        
        $galeria = $this->getDoctrine()->getRepository("FnxAdminBundle:Galeria")->findOneBy(array("atividade" => $id));
        if ($galeria == null){
            $galeria = false;
        }
        
        return array("galeria" => $galeria,
                     "id" => $id);
    }
    
    /**
     * 
     * @Route("adm/galeria/remove/{id}", name="galeriaRemove")
     * @Template()
     */
    public function removeAction($id){
        
        $galeria = $this->getDoctrine()->getRepository("FnxAdminBundle:Galeria")->findOneBy(array("atividade" => $id));
        if ($galeria == null){
            $this->get("session")->setFlash("success","Galeria já está vazia");
            return $this->redirect($this->generateUrl("atividadeShow", array("id" => $id)));
        }
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($galeria);
        $em->flush();
        $this->get("session")->setFlash("success","Fotos excluídas");
        return $this->redirect($this->generateUrl("atividadeShow", array("id" => $id)));
        
    } 
}

?>
