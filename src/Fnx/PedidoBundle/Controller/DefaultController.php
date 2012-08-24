<?php

namespace Fnx\PedidoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/adm/listar/{condicao}",name="PedidoListar",defaults={"condicao" = "abertos"})
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
}
