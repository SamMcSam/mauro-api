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
          //@todo DEBUG! do from bd 
            $siteFetcher = $this->get("mauro.data.site_fetcher");
            $data = $siteFetcher->saveThisWeeksMenu(false);

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    /**
     * @Route("/selection/today")
      * @ApiDoc(
      *  description="Create a new Object",
      *  input="Your\Namespace\Form\Type\YourType",
      *  output="Your\Namespace\Class"
      * )
     */
    public function getSelectionTodayAction()
    {
        $view = $this->view("", 200);
        return $this->handleView($view);
    }

    /**
     * @Route("/selection/tomorrow")
      * @ApiDoc(
      *  description="Create a new Object",
      *  input="Your\Namespace\Form\Type\YourType",
      *  output="Your\Namespace\Class"
      * )
     */
    public function getSelectionTomorrowAction()
    {
        $view = $this->view("", 200);
        return $this->handleView($view);
    }
}
