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
        $session = $this->getRequest()->getSession();

        $pedido = $session->get('pedido', null);

        if(!$pedido):

            $pedido = new \Fnx\PedidoBundle\Entity\Pedido();
            $pedido->setStatus('r');

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($pedido);
            $em->flush();

            $session->set('pedido', $pedido);
        endif;

        $form = $this->createForm(new \Fnx\PedidoBundle\Form\PedidoType(), $pedido);

        if($this->getRequest()->getMethod() == "POST"){

            $request = $this->getRequest();
            $form->bindRequest($request);

            if($form->isValid()){

            }
        }else{
                return $this->render("FnxPedidoBundle:Pedido:Cadastrar.html.twig",array('form' => $form,
                    'tags' => $this->getDoctrine()->getEntityManager()
                ->getRepository("FnxAdminBundle:Cliente")->findAll()));
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

     /**
      * @Route(name="PedidoCadastraCliente", options={ "expose" = true})
      */
     public function cadastraClienteAction(){

         /**
          * @todo metodo que salva um cliente e retorna um booleano de status
          */
         $flag = (bool) $this->getDoctrine()->getRepository("FnxAdminBundle:Cliente");

         echo json_encode(array('flag' => $flag));
         return ;
     }

     /**
      * @Route(name="PedidoVerificaCliente", options={ "expose" = true})
      */
     public function verificaClienteAction(){

         $request = $this->getRequest()->request;

         $obj = $this->getDoctrine()->getRepository("FnxAdminBundle:Cliente")->findBy(array("nome like ".$request->get('form_nome_cliente')));

         echo json_encode($obj);
         return ;
     }

     /**
      * @Route(name="PedidoAdicionaItem", options={ "expose" = true})
      */
     public function adicionaItemAction(){

         $session = $this->getRequest()->getSession();

         $session->get('pedido');

         $obj = $this->getDoctrine()->getRepository("FnxAdminBundle:Cliente")->findBy(array("nome like ".$request->get('form_nome_cliente')));

         echo json_encode($obj);
         return ;
     }
}
