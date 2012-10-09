<?php

namespace Fnx\PedidoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Fnx\AdminBundle\Entity\Cliente;

/**
 * @Route("pedidos/")
 */
class PedidoController extends Controller
{
    /**
     * @Route("listar/",name="PedidoListar")
     * @Template()
     */
    public function indexAction()
    {
        $pedidos = $this->getDoctrine()->getRepository("FnxPedidoBundle:Pedido")->findAll();

        return $this->render("FnxPedidoBundle:Default:index.html.twig",array('pedidos' => $pedidos));
    }

    /**
     * @Route("cadastrar/",name="PedidoCadastrar")
     * @Template()
     */
    public function cadastrarAction(Request $request)
    {
        $session = $this->getRequest()->getSession();

        $pedido = $session->get('pedido', null);

        if(!$pedido):
            $pedido = new \Fnx\PedidoBundle\Entity\Pedido();
            $pedido->setStatus('r');

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($pedido);

            $session->set('pedido', $pedido);
	endif;

	$form = $this->createForm(new \Fnx\PedidoBundle\Form\PedidoType(), $pedido);

	$form_item = $this->createForm(new \Fnx\PedidoBundle\Form\ItemType(), new \Fnx\PedidoBundle\Entity\Item());

        if($request->getMethod() == "POST"){
	    $form->bindRequest($request);

            if($form->isValid()){
		//$this->getDoctrine()->getEntityManager()->persist($form);

		return $this->redirect($this->generateUrl('PedidoListar'));
            }
        }else{
            $sth = $this->getDoctrine()->getEntityManager()->createQuery("select c.nome from \Fnx\AdminBundle\Entity\Cliente c");

	    $sth->execute();

	    $autoComplete = $sth->getResult();

	    if($autoComplete):
		array_walk($autoComplete,
			function(&$str){
				$str = '"'.$str['nome'].'"';
			    });

	    else:
		$autoComplete = array();
	    endif;

	    return $this->render("FnxPedidoBundle:Pedido:Cadastrar.html.twig",array(
		    'form' => $form->createView(),
		    'form_item' => $form_item->createView(),
                    'array_clientes' => $autoComplete
			)
		    );
        }
    }

    /**
     * @Route("editar/{id}",name="PedidoEditar")
     * @Template()
     */
     public function editarAction($id){

         $pedido = $this->getDoctrine()->getRepository("FnxPedidoBundle:Pedido")->find($id);

         $form = $this->createForm(new \Fnx\PedidoBundle\Form\PedidoType(), $pedido);

         return $this->render("FnxPedidoBundle:Pedido:Editar.html.twig", array('pedido' => $pedido, 'form' => $form->createView()));
     }

     /**
      * @Route("cadastraCliente",name="PedidoCadastraCliente", options={ "expose" = true})
      */
     public function cadastraClienteAction(){

         /**
          * @todo metodo que salva um cliente e retorna um booleano de status
          */
         $em = $this->getDoctrine()->getEntityManager();

	 $json = $this->getRequest()->get('cliente');

	 $cliente = json_decode($json);

	 ob_start();
	 print_r($cliente);
	 $var_dump = ob_get_contents();
	 ob_end_clean();

	 //$flag = $em->persist($cliente);

         echo json_encode(array('flag' => false /*$flag*/, "cliente" => $var_dump));

         return new \Symfony\Component\HttpFoundation\Response();
     }

     /**
      * @Route("confereCliente",name="PedidoVerificaCliente", options={ "expose" = true})
      */
     public function verificaClienteAction(){

         $request = $this->getRequest();

         $cliente = $this->getDoctrine()
		    ->getEntityManager()
		    ->getRepository("FnxAdminBundle:Cliente")
		    ->findOneBy(array('nome' => $request->get('nome')));

	 $obj['nome'] = $cliente->getNome();
	 $obj['tel']  = $cliente->getTelefone();
	 $obj['desc'] = $cliente->getDescricao();
	 $obj['tipo'] = ($cliente->ehJuridica())? 'CNPJ: ': 'CPF: ' ;
	 $obj['disc'] = ($cliente->ehJuridica())? $cliente->getCnpj() : $cliente->getCpf();


	 $response = new \Symfony\Component\HttpFoundation\Response(json_encode($obj));
	 $response->headers->set('content/type', 'application/json');

         return $response;
     }

     /**
      * @Route("addItem",name="PedidoAdicionaItem")
      */
     public function adicionaItemAction(){

         $request = $this->getRequest();

         $pedido = $request->getSession()->get('pedido');

	 // isso aqui seria no caso dos produtos serem registrados no banco
	 //$sth = $this->getDoctrine()->getEntityManager()->createQuery("select i from \Fnx\PedidoBundle\Entity\Item where i.nome = ?;");

	 $item = new \Fnx\PedidoBundle\Entity\Item();

	 $item->setNome($request->get("nome"));

	 $item->setDescricao($request->get("descricao"));

	 $item->setPreco($request->get("preco"));

	 $item->setQuantidade($request->get("quantidade"));

	 $pedido->getItens()->add($item);

	 $obj['nome']	    = $item->getNome();
	 $obj['descricao']  = $item->getDescricao();
	 $obj['quantidade'] = $item->getQuantidade();
	 $obj['valor']	    = $item->getPreco();

         $response = new \Symfony\Component\HttpFoundation\Response(json_encode($obj));

	 return $response;
     }
}