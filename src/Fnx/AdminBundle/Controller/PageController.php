<?php

namespace Fnx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/adm")
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="adminHome")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
