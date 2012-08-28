<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fnx\AdminBundle\Form\Handler;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Fnx\AdminBundle\Entity\Usuario;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
/**
 * Description of UsuarioFormHandler
 *
 * @author bondcs
 */
class UsuarioFormHandler {
    
    private $form;
    private $em;
    private $request;
    
    public function __construct(Form $form, Request $request, EntityManager $em) {
        
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
    }
    
    public function process(Usuario $usuario, $funcli){
        
        $password = $usuario->getPassword();
        $this->form->setData($usuario);

        if ($this->request->getMethod() == "POST"){
            $this->form->bindRequest($this->request);
            if($this->form->isValid()){
                $this->onSuccess($usuario, $funcli, $password);
                return true;
            }
        }
        
        return false;
        
    }
    
    public function onSuccess(Usuario $usuario, $funcli, $password){
        
        $passwordForm = $this->form->getData()->getPassword();
        
        if (!$usuario->getId() || $passwordForm != null){
            
           $usuario->setSalt(md5(time()));
           $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
           $password = $encoder->encodePassword($passwordForm, $usuario->getSalt());
        }
        
        $funcli->getUsuario()->setPassword($password);
                
        $this->em->persist($usuario);
        $this->em->flush();
    }
}

?>
