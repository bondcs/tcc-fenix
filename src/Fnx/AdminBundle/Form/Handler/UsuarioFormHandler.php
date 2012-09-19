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
    
    public function process(Usuario $usuario, $father){
        
        $this->form->setData($usuario);

        if ($this->request->getMethod() == "POST"){
            $this->form->bindRequest($this->request);
            if($this->form->isValid()){
                $this->onSuccess($usuario, $father);
                return true;
            }
        }
        
        return false;
        
    }
    
    public function onSuccess(Usuario $usuario, $father){
        
        if (!$usuario->getId()){
            
           $usuario->setSalt(md5(time()));
           $data = $this->form->getData();
           $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
           $password = $encoder->encodePassword($data->getPassword(), $usuario->getSalt());
        }
                
        $father->getUsuario()->setPassword($password);
        $this->em->persist($usuario);
        $this->em->flush();
    }
}

?>
