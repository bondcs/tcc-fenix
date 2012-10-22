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
use Fnx\AdminBundle\Entity\Atividade;
use Fnx\AdminBundle\Entity\Contrato;
use Fnx\AdminBundle\Form\Type\AtividadeType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Fnx\AdminBundle\Form\Type\FuncionarioType;
use Fnx\AdminBundle\Entity\Funcionario;
/**
 * Description of SalarioController
 *
 * @author bondcs
 * @Route("/adm/funcionario/salario")
 */
class SalarioController extends Controller{
    
    
    /**
     * @Route("/", name="salarioHome")
     * @Template()
     */
    public function indexAction(){
        
//        $dbal = $this->get('database_connection');
//        $stmt = $dbal->query('SELECT * FROM atividade');
//        var_dump($stmt->fetchAll());die()
        $formFilter = $this->createForm(new \Fnx\FinanceiroBundle\Form\Type\FilterType());
        return array("formFilter" => $formFilter->createView());
        
    }
    
    /**
     * @Route("/edit/{id}", name="funcionarioSalarioEdit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id){
        $funcionario = $this->getDoctrine()->getRepository("FnxAdminBundle:Funcionario")->find($id);
        if (!$funcionario){
            throw $this->createNotFoundException("Funcionário não encontrado.");
        }

        $form = $this->createForm(new FuncionarioType, $funcionario);
        $salarioOld = $funcionario->getSalario();
        $request = $this->getRequest();
        if ($request->getMethod() == "POST"){
            $form->bindRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $funcionario->setSalario($salarioOld);
                $funcionario->setTipo("fun");
                $funcionario->setSalarioPago($funcionario->getBonus() + $funcionario->getSalarioPago());
                $em->persist($funcionario);
                $em->flush();
                
                $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'edit'
                );

                $response = new Response(json_encode($responseSuccess));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }
        
        return array("form" => $form->createView(),
                    "funcionario" => $funcionario);
    }
    
    /**
     * @Route("/ajaxSalario", name="escalaSalario", options={"expose" = true})
     * @Template()
     */
    public function ajaxAction(){
        
        $salariosBanco = $this->getDoctrine()->getRepository("FnxAdminBundle:Funcionario")->loadSalario();
        $salarios['aaData'] = array();
        
        foreach ($salariosBanco as $key => $value) {
            $value['dataPagamento'] = $value['dataPagamento']->format('d/m/Y H:i:s')." (".$value['dataPagamento']->diff(new \Datetime)->d." dias)";
            $salarios['aaData'][] = $value;
        }
       
        $response = new Response(json_encode($salarios));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    
}

?>
