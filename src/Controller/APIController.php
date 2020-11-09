<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/menu", name="menu_list")
     */
    public function getMenu(): Response
    {
        // @todo from data
        $list = [
            [
                'id' => 1,
                'date' => "2020-11-09",
                'items' => [
                    "Emincé de veau au pesto rosso (HOL)",
                    "Bocconcini de dinde à l’aigre doux (FR)",
                    "Pommes sablées",
                    "Haricots verts",
                    "Risotto aux artichauts et finocchiona",
                    "Orecchiette aux aubergines",
                ]
            ],
            [
                'id' => 2,
                'date' => "2020-11-10",
                'items' => [
                    "Fricassé de pintade aux épices (FR)",
                    "Emincé de poulet au citron vert (HUG)",
                    "Aubergines au four",
                    "Arancini",
                    "Penne Alfredo",
                    "Paccheri au mascarpone et magret de canard fumé",
                    "Risotto borlotti et pancetta",
                ]
            ],
            [
                'id' => 3,
                'date' => "2020-11-11",
                'items' => [
                    "Fricandeaux de boeuf au vin rouge (CH)",
                    "Blanquette de veau à l’ancienne (HOL)",
                    "Pommes au four",
                    "Choux fleur",
                    "Risotto aux échalotes et petit pois",
                    "Farfalle 4 fromages",
                    "Gnocchi Albese",
                ]
            ],
            [
                'id' => 4,
                'date' => "2020-11-12",
                'items' => [
                    "Cuisse de poulet farcie aux châtaignes(FR)",
                    "Filet mignon au lard de colonnata(CH)",
                    "Croquettes de pommes de terre",
                    "Petits pois et carottes",
                    "Risotto à la saucisse",
                    "Tortiglioni carbonara",
                    "Ziti tomate et basilic",
                ]
            ],
            [
                'id' => 5,
                'date' => "2020-11-13",
                'items' => [
                    "Sauté de crevettes méditerranéenne (FR)",
                    "Filets de carrelet aux poireaux (FR)",
                    "Sticks de poulet panés aux olives (CH)",
                    "Pommes à la crème",
                    "Epinards en branche",
                    "Risotto moscardini et seppie",
                    "Mezzi rigatoni al Taleggio",
                ]
            ],
        ];

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($list));

        return $response;
    }

    /**
     * @Route("/stats", name="stats_list")
     */
    public function getStats(): Response
    {
        $stats = []; // @todo

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($stats));

        return $response;
    }

    /**
     * @Route("/predictions", name="predictions_list")
     */
    public function getPredictions(): Response
    {
        $predictions = []; // @todo

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($predictions));

        return $response;
    }
}
