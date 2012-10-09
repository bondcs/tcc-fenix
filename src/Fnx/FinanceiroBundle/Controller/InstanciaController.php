<?php

namespace Fnx\FinanceiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fnx\FinanceiroBundle\Entity\Instancia;
use Fnx\FinanceiroBundle\Form\Type\InstanciaType;

/**
 * Instancia controller.
 *
 * @Route("/financeiro/instancia")
 */
class InstanciaController extends Controller
{
    /**
     * Lists all Instancia entities.
     *
     * @Route("/", name="financeiro_instancia")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('FnxFinanceiroBundle:Instancia')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Instancia entity.
     *
     * @Route("/{id}/show", name="financeiro_instancia_show", options={"expose" = true})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxFinanceiroBundle:Instancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instancia entity.');
        }
        return array(
            'entity' => $entity  );
    }

    /**
     * Displays a form to create a new Instancia entity.
     *
     * @Route("/new", name="financeiro_instancia_new", options={"expose" = true})
     * @Template()
     */
    public function newAction()
    {
        $entity = new Instancia();
        $form   = $this->createForm(new InstanciaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Instancia entity.
     *
     * @Route("/create", name="financeiro_instancia_create")
     * @Method("post")
     * @Template("FnxFinanceiroBundle:Instancia:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Instancia();
        $request = $this->getRequest();
        $form    = $this->createForm(new InstanciaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            $this->get("session")->setFlash("success","Cadastro concluído.");
            return $this->redirect($this->generateUrl("financeiro_instancia"));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Instancia entity.
     *
     * @Route("/{id}/edit", name="financeiro_instancia_edit", options={"expose" = true})
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxFinanceiroBundle:Instancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instancia entity.');
        }

        $editForm = $this->createForm(new InstanciaType(), $entity);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Instancia entity.
     *
     * @Route("/{id}/update", name="financeiro_instancia_update")
     * @Method("post")
     * @Template("FnxFinanceiroBundle:Instancia:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('FnxFinanceiroBundle:Instancia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instancia entity.');
        }

        $editForm   = $this->createForm(new InstanciaType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get("session")->setFlash("success","Cadastro alterado.");
            return $this->redirect($this->generateUrl("financeiro_instancia"));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Instancia entity.
     *
     * @Route("/{id}/delete", name="financeiro_instancia_delete", options={"expose" = true})
     */
    public function deleteAction($id)
    {

       $em = $this->getDoctrine()->getEntityManager();
       $entity = $em->getRepository('FnxFinanceiroBundle:Instancia')->find($id);

       if (!$entity) {
            throw $this->createNotFoundException('Unable to find Instancia entity.');
       }

       $em->remove($entity);
       $em->flush();
       
       $this->get("session")->setFlash("success","Cadastro excluído.");
       return $this->redirect($this->generateUrl('financeiro_instancia'));
    }

}
