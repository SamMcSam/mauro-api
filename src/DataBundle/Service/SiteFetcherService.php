<?php

namespace DataBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Guzzle\Http\Client;
use Symfony\Component\DomCrawler\Crawler;

use DataBundle\Entity\Selection;

/**
 * Crawls to the site and fetches entries
 */
class SiteFetcherService extends Controller
{
  protected $url;

  protected $logger;

  function __construct($url, $logger) {
    $this->url = $url;
    $this->logger = $logger;
  }

  function getCurrentMenuFromSite() {
    try {
      $client = new Client();
      $request = $client->get($this->url);
      $response = $request->send();

      $crawler = new Crawler((string)$response->getBody());

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
      $this->logger->critical("[SITEFETCHER] : " . $e->getMessage());
    }

    return null;
  }

  function getSelectionObject($domElement) {
    try {
      $selectionArray = [];

      // each menu item
      foreach ($domElement->childNodes as $p) {
        $content = trim($p->nodeValue);
        if (!empty($content)) {
          $selectionArray[] = $content;
        }
      }

      return Selection::generateFromArray($selectionArray);
    } catch (\Exception $e) {
      $this->logger->critical("[DOMELEMENT PARSER] : " . $e->getMessage());
    }

    return null;
  }
}
