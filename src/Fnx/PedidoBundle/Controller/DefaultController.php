<?php

namespace Fnx\PedidoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/pedidos/listar/{condicao}",name="PedidoListar",defaults={"condicao" = "abertos"})
     * @Template()
     */
    public function indexAction($condicao = "abertos")
    {
        switch ($condicao):
            case "abertos":
                $where = " where p.dataPagamento is null";
            case "todos":
                $where = '';
            case "historico":
                $where = "  where p.dataPagamento is not null";
            case "atrasados":
                $where = " where p.dataPagamento < CURRENT_DATE()";
        endswitch;
        
        $em = $this->getDoctrine()->getEntityManager();
                
        $qb = $em->createQuery("select p from \Fnx\PedidoBundle\Entity\Pedido p".$where);
        
        return $this->render("FnxPedidoBundle:Default:index.html.twig",array('pedidos' => $qb->getResult()));
    }
    
    /**
     * @Route("/pedidos/cadastrar",name="PedidoCadastrar")
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
            return $this->render("FnxPedidoBundle:Pedido:Cadastrar.html.twig",array('form' => $form, 'tags' => array("ActionScript","AppleScript","Asp",
        "BASIC","C","C++","Clojure","COBOL","ColdFusion","Erlang",
        "Fortran","Groovy","Haskell","Java","JavaScript","Lisp",
        "Perl","PHP","Python","Ruby","Scala","Scheme") ));
    }
        
    }
}
