<?php

namespace APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Route("/api")
 */
class APIController extends FOSRestController
{
    /**
     * @Route("/menu/week")
      * @ApiDoc(
      *  description="Create a new Object",
      *  input="Your\Namespace\Form\Type\YourType",
      *  output="Your\Namespace\Class"
      * )
     */
    public function getMenuByWeekAction()
    {
        $siteFetcher = $this->get("mauro.data.site_fetcher");

        $menus = $siteFetcher->getCurrentMenuFromSite();

        $view = $this->view($menus, 200);
        return $this->handleView($view);
    }
}
