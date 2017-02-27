<?php

namespace DataBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Guzzle\Http\Client;
use Symfony\Component\DomCrawler\Crawler;

use DataBundle\Entity\Menu;
use DataBundle\Entity\Selection;

/**
 * Crawls to the site and fetches entries
 */
class SiteFetcherService extends Controller
{
  protected $url;

  protected $em;

  protected $logger;

  protected $response;

  function __construct($url, $em, $logger) {
    $this->url = $url;
    $this->em = $em;
    $this->logger = $logger;
  }

  public function getCurrentWeekFromSite($refresh = true) {
    try {
      if ($refresh) {
        $client = new Client();
        $request = $client->get($this->url);
        $this->response = $request->send();
      }

      if (is_null($this->response)) {
        throw new \Exception("No response given.");
      }

      $crawler = new Crawler((string)$this->response->getBody());

      $title = $crawler
        ->filter('td:first-child')
      ;

      $titleString = $title->text();

      preg_match("#.*du .* au (.*)\r.*#", $titleString, $dates);

      // @todo IntlDateFormatter not working??
      $find = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
      $replace = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
      $day = new \DateTime(str_replace($find, $replace, strtolower($dates[1])));

      $sunday = $day->sub(new \DateInterval('P'.$day->format('w').'D'));

      return $sunday;
    } catch (\Exception $e) {
      $this->logger->critical("[SITEFETCHER-weekdate] : " . $e->getMessage());
    }

    return null;
  }

  public function getCurrentMenuFromSite($refresh = true) {
    try {
      if ($refresh) {
        $client = new Client();
        $request = $client->get($this->url);
        $this->response = $request->send();
      }

      if (is_null($this->response)) {
        throw new \Exception("No response given.");
      }

      $crawler = new Crawler((string)$this->response->getBody());

      $tds = $crawler
        ->filter('td:not(:first-child):not(:last-child)')
      ;

      $daySelections = [];

      // each day
      /** DOMElement $domELement */
      foreach ($tds as $domElement) {
          $daySelections[] = $domElement;
      }

      return $daySelections;
    } catch (\Exception $e) {
      $this->logger->critical("[SITEFETCHER-currentmenu] : " . $e->getMessage());
    }

    return null;
  }

  public function getSelectionObject($domElement, $persist = true) {
    try {
      $selectionArray = [];

      // each menu item
      foreach ($domElement->childNodes as $p) {
        $content = trim($p->nodeValue);
        if (!empty($content)) {
          $selectionArray[] = $content;
        }
      }

      return Selection::generateFromArray($this->em, $selectionArray, $persist);
    } catch (\Exception $e) {
      $this->logger->critical("[DOMELEMENT PARSER] : " . $e->getMessage());
    }

    return null;
  }

  public function saveThisWeeksMenu($flush = true)
  {
    $menus = $this->getCurrentMenuFromSite();
    $sunday = $this->getCurrentWeekFromSite(false);

    $objectArray = [];
    foreach ($menus as $menu) {
      $objectArray[] = $this->getSelectionObject($menu, true);
    }

    $menu = new Menu();
    $menu->setWeek($sunday);
    $menu->addSelectionArray($objectArray);
    $this->em->persist($menu);

    if ($flush) {
      $this->em->flush();
    }

    return [
      "sunday" => $sunday,
      "menu" => $menu,
    ];
  }
}
