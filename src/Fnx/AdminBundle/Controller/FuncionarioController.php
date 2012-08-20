<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fnx\AdminBundle\Entity\Funcionario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fnx\AdminBundle\Form\FuncionarioType;
use Fnx\AdminBundle\Entity\Usuario;
use Fnx\AdminBundle\Form\UsuarioType;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Fnx\AdminBundle\Form\ChangePasswordType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FuncionarioController
 *
 * @author bondcs
 */
class FuncionarioController extends Controller{
    
    /**
     * @Route("adm/funcionario", name="funcionarioHome")
     * @Template()
     */
    public function indexAction(){
       $funcionarios = $this->getDoctrine()->getRepository("FnxAdminBundle:Funcionario")->findAll(); 
       return array("funcionarios" => $funcionarios);
    }
    
    /**
     * @Route("adm/funcionario/add", name="funcionarioAdd", options={"expose" = true})
     * @Template()
     */
    public function addAction(){
        
        $funcionario = new Funcionario();
        $form = $this->createForm(new FuncionarioType, $funcionario);
        $request = $this->getRequest();
        if ($request->getMethod() == "POST"){
            $form->bindRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($funcionario);
                $em->flush();
                
                $session = $this->get("session")->setFlash("success","Cadastro concluído.");
                return $this->redirect($this->generateUrl("funcionarioHome"));
            }else{
                $session = $this->get("session")->setFlash("error","O formulário não foi validado.");
            }
        }
        
        return $this->render("FnxAdminBundle:Funcionario:form.html.twig", array(
                    "form" => $form->createView(),
                    "funcionario" => $funcionario));
    }
    
    /**
     * @Route("adm/funcionario/edit/{id}", name="funcionarioEdit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id){
        $funcionario = $this->getDoctrine()->getRepository("FnxAdminBundle:Funcionario")->find($id);
        if (!$funcionario){
            throw $this->createNotFoundException("Funcionário não encontrado.");
        }
        $form = $this->createForm(new FuncionarioType, $funcionario);
        $request = $this->getRequest();
        if ($request->getMethod() == "POST"){
            $form->bindRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($funcionario);
                $em->flush();
                
                $session = $this->get("session")->setFlash("success","Alteração concluída.");
                return $this->redirect($this->generateUrl("funcionarioHome"));
            }else{
                $session = $this->get("session")->setFlash("error","O formulário não foi validado.");
            }
        }
        
        return $this->render("FnxAdminBundle:Funcionario:form.html.twig", array(
                    "form" => $form->createView(),
                    "funcionario" => $funcionario));
    }
    
    /**
     * @Route("adm/funcionario/remove/{id}", name="funcionarioRemove", options={"expose" = true})
     */
    public function removeAction($id){
       $funcionario = $this->getDoctrine()->getRepository("FnxAdminBundle:Funcionario")->find($id);
       if (!$funcionario){
            throw $this->createNotFoundException("Funcionário não encontrado.");
        }
       $em = $this->getDoctrine()->getEntityManager();
       $em->remove($funcionario);
       $em->flush();
       $this->get('session')->setFlash('success', 'Funcionário excluído.');  
       return $this->redirect($this->generateUrl("funcionarioHome"));
    }
    
    /**
     * @Route("adm/funcionario/show/{id}", name="funcionarioShow", options={"expose" = true})
     * @Template()
     */
    public function showProfileAction($id){
        $funcionario = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository("FnxAdminBundle:Funcionario")
                    ->find($id);
        
        if (!$funcionario){
            throw $this->createNotFoundException("Funcionário não encontrado.");
        }
        
        
        return array("funcionario" => $funcionario);
    }
    
    /**
     * @Route("adm/funcionario/show/add-user/{id}", name="funcionarioAddUser", options={"expose" = true})
     * @Template()
     */
    public function addUserAction($id){
        
        $funcionario = $this->getDoctrine()->getRepository("FnxAdminBundle:Funcionario")->find($id);
        if(!$funcionario){
            throw $this->createNotFoundException("Funcionário não encontrado.");
        }
        
        if(!$funcionario->getUsuario()){
           $funcionario->setUsuario(new Usuario());
           $form = $this->createForm(new UsuarioType, $funcionario->getUsuario(), array('validation_groups'=>'register'));
        }else{
           $form = $this->createForm(new UsuarioType, $funcionario->getUsuario(), array('validation_groups'=>'edit'));
           $password = $funcionario->getUsuario()->getPassword();
        }
                
        $request = $this->getRequest();
        if ($request->getMethod() == "POST"){
            $form->bindRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                
                if (!$funcionario->getUsuario()->getId()){
                    $funcionario->getUsuario()->setSalt(md5(time()));
                    $data = $form->getData();
                    $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
                    $password = $encoder->encodePassword($data->getPassword(), $funcionario->getUsuario()->getSalt());
                }
                
                $funcionario->getUsuario()->setPassword($password);
                $em->persist($funcionario);
                $em->flush();
                
                $this->get('session')->setFlash("success","Usuário alterado com sucesso.");
                return $this->redirect($this->generateUrl("funcionarioShow", array(
                    "id" => $funcionario->getId(),
                )));
            }else{
                $this->get('session')->setFlash("error","Fomulário não foi validado.");
            }
            
        }
        if($funcionario->getUsuario()->getId()){
            return $this->render("FnxAdminBundle:Funcionario:editUser.html.twig", array(
                'form' => $form->createView(),
                'usuario' => $funcionario->getUsuario(),
                'funcionario' => $funcionario,
            ));
        }
        
        if($request->isXmlHttpRequest()){
            return $this->render('FnxAdminBundle:Funcionario:test.html.twig',array(
                    'form' => $form->createView(),
                    'usuario' => $funcionario->getUsuario(),
                    'funcionario' => $funcionario,
            ));
        } 
        
        return array(
            'form' => $form->createView(),
            'usuario' => $funcionario->getUsuario(),
            'funcionario' => $funcionario,
        );
    }
    
    /**
     * @Route("adm/funcionario/show/remove-user/{id}/{idUsuario}", name="funcionarioRemoveUser", options={"expose" = true})
     */
    public function removerUserAction($id, $idUsuario){
        
        $em = $this->getDoctrine()->getEntityManager();
        $usuarioLogado = $user = $this->get('security.context')->getToken()->getUser();
        
        if($usuarioLogado->getId() == $idUsuario){
            throw new \Exception("Você não pode excluir um usuário logado.");   
        }
        
        $this->get('session')->setFlash("success","Usuário excluído com sucesso.");
        $em->remove($em->find("FnxAdminBundle:Usuario", $idUsuario));
        $em->flush();
            
        return $this->redirect($this->generateUrl("funcionarioShow", array(
           'id' => $id, 
        )));
        
    }
    
    /**
     * @Route("adm/funcionario/show/add-user/change-senha/{id}/{idFuncionario}", name="funcionarioUserSenha")
     * @Template()
     */
    public function changePasswordAction($id, $idFuncionario){
        
        $form = $this->createForm(new ChangePasswordType());
        $usuario = $this->getDoctrine()->getRepository("FnxAdminBundle:Usuario")->find($id);
        $funcionario = $this->getDoctrine()->getRepository("FnxAdminBundle:Funcionario")->find($idFuncionario);
        $request = $this->getRequest();
            if ($request->getMethod() == "POST"){
                $form->bindRequest($request);
                if ($form->isValid()){
                    
                    $usuario->setSalt(md5(time()));
                    $data = $form->getData();
                    $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
                    $password = $encoder->encodePassword($data['password'], $usuario->getSalt());
                    $usuario->setPassword($password);
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->merge($usuario);
                    $em->flush();
                    
                    $this->get('session')->setFlash("success","Senha alterada com sucesso.");
                    
                    $responseSuccess = array('success' => $this->generateUrl("funcionarioAddUser", array(
                                    "id" => $funcionario->getId(),
                                )));
                    $response = new Response(json_encode($responseSuccess));
                    $response->headers->set('Content-Type', 'application/json');
        
                    return $response;
                    
                }
            }
         
        
        return $this->render("FnxAdminBundle:Funcionario:changePassword.html.twig", array(
            "form" => $form->createView(),
            "usuario" => $usuario,
            "funcionario" => $funcionario,
            ));

    }
}

?>
