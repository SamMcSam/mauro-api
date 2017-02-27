<?php

namespace APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 */
class APIController extends FOSRestController
{
    /**
     * @Rest\Get("/menu/week")
     * @ApiDoc(
     *  description="Gets the menu for a week (default this week)"
     *)
     *
     * @Rest\QueryParam(
     *  name="week",
     *  requirements="[0-9]+",
     *  nullable=true,
     *  description="Negative index relative to this week. Ex : 1 is last week, 2 is two weeks ago, etc... Default (0) is this weeks"
     * )
    */
    public function getMenuByWeekAction(Request $request)
    {
        if ($request->query->has('week')) {
          $index = $request->query->get('week') * -1 + -1;
        }
        else {
          $index = -1;
        }

        $lastSunday = new \DateTime();
        $lastSunday->modify($index . ' Sunday');

        $em = $this->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository("DataBundle:Menu");

        $data = $repo->findOneByWeek($lastSunday);

        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/selection/day")
     * @ApiDoc(
     *  description="Gets the selection for a day (default today)"
     *)
     *
     * @Rest\QueryParam(
     *  name="dow",
     *  requirements="[0123456]",
     *  nullable=true,
     *  description="Day of the week index (default is current day)"
     * )
    */
    public function getSelectionByDayAction(Request $request)
    {
        $date = new \DateTime();
        $dow = $date->format("w");

        $lastSunday = $date->modify('-1 Sunday');

        $em = $this->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository("DataBundle:Menu");

        // @todo get from repo

        $view = $this->view(null, 200);
        return $this->handleView($view);
    }
}
