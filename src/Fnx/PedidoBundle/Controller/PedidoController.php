<?php

namespace Fnx\PedidoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("pedidos/")
 */
class PedidoController extends Controller
{
    /**
     * @Route("listar/{condicao}",name="PedidoListar",defaults={"condicao" = "abertos"})
     * @Template()
     */
    public function indexAction($condicao = "abertos")
    {
        
        $pedidos = $this->getDoctrine()->getRepository("FnxPedidoBundle:Pedido")->loadPedidos($condicao);
                
        return $this->render("FnxPedidoBundle:Default:index.html.twig",array('pedidos' => $pedidos));
    }
    
    /**
     * @Route("cadastrar/",name="PedidoCadastrar")
     * @Template()
     */
    public function cadastrarAction()
    {       
        $pedido = new \Fnx\PedidoBundle\Entity\Pedido();
        $pedido->setCliente(new \Fnx\AdminBundle\Entity\Cliente());
        $pedido->setPrevisao(new \DateTime());
        
        $form = $this->createForm(new \Fnx\PedidoBundle\Form\PedidoType(), $pedido);
                
        if($this->getRequest()->getMethod() == "POST"){
            
            $request = $this->getRequest();
            $form->bindRequest($request);            
            
            if($form->isValid()){
                
            }
        }else{
                return $this->render("FnxPedidoBundle:Pedido:Cadastrar.html.twig",array('form' => $form, 
                    'tags' => array("ActionScript","AppleScript","Asp",
            "BASIC","C","C++","Clojure","COBOL","ColdFusion","Erlang",
            "Fortran","Groovy","Haskell","Java","JavaScript","Lisp",
            "Perl","PHP","Python","Ruby","Scala","Scheme") ));
        }        
    }
    
    /**
     * @Route("editar/{id}",name="PedidoEditar", options={ "expose" = true})
     * @Template()
     */
     public function editarAction($id){
         
         $pedido = $this->getDoctrine()->getRepository("FnxPedidoBundle:Pedido")->find($id);
         
         $form = $this->createForm(new \Fnx\PedidoBundle\Form\PedidoType(), $pedido);
         
         return $this->render("FnxPedidoBundle:Pedido:Editar.html.twig", array('pedido' => $pedido, 'form' => $form->createView()));
     }
}
