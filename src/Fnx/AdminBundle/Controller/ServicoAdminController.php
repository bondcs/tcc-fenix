<?php

namespace Fnx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Fnx\AdminBundle\Entity\ServicoAdmin;
use Fnx\AdminBundle\Form\Type\ServicoAdminType;

/**
 * ServicoAdmin controller.
 *
 * @Route("adm/atividade/show/admin")
 */
class ServicoAdminController extends Controller
{
    /**
     * Lists all ServicoAdmin entities.
     *
     * @Route("/", name="funcionario_servico_admin")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('FnxAdminBundle:ServicoAdmin')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Displays a form to create a new ServicoAdmin entity.
     *
     * @Route("/new", name="funcionario_servico_admin_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ServicoAdmin();
        
        $form   = $this->createForm(new ServicoAdminType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ServicoAdmin entity.
     *
     * @Route("/create", name="funcionario_servico_admin_create")
     * @Method("post")
     * @Template("FnxAdminBundle:ServicoAdmin:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ServicoAdmin();
        $request = $this->getRequest();
        $form    = $this->createForm(new ServicoAdminType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'add'
            );
            
            return $this->responseAjax($responseSuccess);
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ServicoAdmin entity.
     *
     * @Route("/{id}/edit", name="funcionario_servico_admin_edit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxAdminBundle:ServicoAdmin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Serviço não encontrado.');
        }

        $editForm = $this->createForm(new ServicoAdminType(), $entity);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing ServicoAdmin entity.
     *
     * @Route("/{id}/update", name="funcionario_servico_admin_update")
     * @Method("post")
     * @Template("FnxAdminBundle:ServicoAdmin:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxAdminBundle:ServicoAdmin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Serviço não encontrado.');
        }

        $editForm   = $this->createForm(new ServicoAdminType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $responseSuccess = array(
                  'dialogName' => '.simpleDialog',
                  'message' => 'edit'
            );
            $this->responseAjax($responseSuccess);
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a ServicoAdmin entity.
     *
     * @Route("/{id}/delete", name="funcionario_servico_admin_delete", options={"expose" = true})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('FnxAdminBundle:ServicoAdmin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Serviço não encontrado.');
        }

        $em->remove($entity);
        $em->flush();
          
        return $this->responseAjax(array());
    }
    
    /**
     * 
     * @Route("/ajaxServico/{id}", name="ajaxServicoAdmin", options={"expose" = true})
     */
    public function ajaxServicoAdminAction($id){
        
        $em = $this->getDoctrine()->getEntityManager();
        $atividade = $em->find("FnxAdminBundle:Atividade", $id);
        $servicoBanco = $em
                    ->createQuery("SELECT s,f FROM FnxAdminBundle:ServicoAdmin s
                                   JOIN s.fornecedor f 
                                   WHERE s.atividade = :atividade")
                    ->setParameter('atividade', $atividade)
                    ->getArrayResult();  
        
        $servicos['aaData'] = array();
        foreach ($servicoBanco as $servico){
            $servico['valorNumber'] = $servico['servico'];
            $servico['valor'] = number_format($servico['servico'],2,',','.');
            $servicos['aaData'][] = $servico;
        }
    
        return $this->responseAjax($servicos);
    }
    
    public function responseAjax($json){
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
